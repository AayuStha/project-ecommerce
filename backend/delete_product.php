<?php
// Connect to the database
include '../config.php';

$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID of the product to be deleted
    $id = $_POST['id'];

    // Prepare an SQL statement
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");

    // Bind the ID to the SQL statement
    $stmt->bind_param("i", $id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect back to admin_panel.php
        header('Location: admin_panel.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Get the ID of the product to be deleted
    $id = $_GET['id'];

    // Fetch the existing product data
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<!-- Display the product data in a form for confirmation -->
<form action="delete_product.php" method="post">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <p>Are you sure you want to delete the following product?</p>
    <p>Name: <?php echo $product['name']; ?></p>
    <p>Price: <?php echo $product['price']; ?></p>
    <input type="submit" value="Delete">
</form>