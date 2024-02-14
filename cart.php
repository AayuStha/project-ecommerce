<?php
    session_start();

    include 'config.php';

    $db = new mysqli($servername, $username, $password, $database);


    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Get the products from the database
    $result = $db->query('SELECT * FROM products');
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Initialize the cart and the total amount
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!isset($_SESSION['total_amount'])) {
        $_SESSION['total_amount'] = 0;
    }

    // Handle the form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'];

        // Add the product to the cart and update the total amount
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 0;
        }
        $_SESSION['cart'][$productId]++;
        $_SESSION['total_amount'] += $products[$productId]['price'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS here */
    </style>
</head>
<body>
    <h1>Total Amount: $<?php echo number_format($_SESSION['total_amount'], 2); ?></h1>

    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            <div>
                <h2><?php echo $product['name']; ?></h2>
                <p>$<?php echo number_format($product['price'], 2); ?></p>
            </div>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>