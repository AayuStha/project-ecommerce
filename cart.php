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
if (!$result) {
    die("Error executing query: " . $db->error);
}
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[$row['id']] = $row;
}

// Initialize the cart and the total amount
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Add the product to the cart and update the total amount
    if (!isset($products[$productId])) {
        die("Invalid product ID: $productId");
    }
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId]++;
    $_SESSION['total_amount'] += $products[$productId]['price'];

    // Redirect to the cart page
    header('Location: cart.php');
    exit;
}

// Calculate the total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $productId => $quantity) {
    if (!isset($products[$productId])) {
        die("Invalid product ID in cart: $productId");
    }
    $total_amount += $products[$productId]['price'] * $quantity;
}
$_SESSION['total_amount'] = $total_amount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/project-ecommerce/css/style.css" class="css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>BagShop Nepal</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.html">
                        BagShopNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.html" class="active">Home</a></li>
                        <li><a href="/project-ecommerce/products.php">Products</a></li>
                        <li><a href="/project-ecommerce/about.html">About</a></li>
                        <li><a href="project-ecommerce/contact.html">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.html">Offers</a></li>
                        <li><a href="/project-ecommerce/login.php">Login</a></li>
                        <li><a href="/project-ecommerce/signup.html">Signup</a></li>
                        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </ul>
                </nav>
                <button id="hamburger-menu" class="hamburger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="cart.php"><img src="images/cart.png" width="30px" height="30px"alt="cart"></a>
            </div>
            <hr id="hr">
        </div>
    </div>
    

    <h2>Shopping Cart</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Remove</th>
        </tr>
        <!-- Repeat this row for each item in the cart -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>$<?php echo $row['price']; ?></td>
            <td><button>Remove</button></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <button style="float: right; margin-top: 20px;">Proceed to Checkout</button>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>