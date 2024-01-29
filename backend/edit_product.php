<html>
    <body>
        


<?php
// Connect to the database
include '../config.php';

error_reporting(E_ALL);

// Display errors in the output
ini_set('display_errors', 1);

$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get the new product data from the form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];


    // Prepare an SQL statement
    $stmt = $db->prepare("UPDATE products SET name = ?, price = ?, rating = ?, description = ? WHERE id = ?");

    // Bind the new product data to the SQL statement
    $stmt->bind_param("ssssi", $name, $price, $rating, $description, $id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect back to admin_panel.php
        header('Location: admin_panel.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Get the ID of the product to be edited
    $id = $_GET['id'];

    // Fetch the existing product data
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<!-- Display the product data in a form for editing -->
<form action="edit_product.php" method="post">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>">
    <label for="price">Price:</label>
    <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>">
    <label for="rating">Rating:</label>
    <input type="text" id="rating" name="rating" value="<?php echo $product['rating']; ?>">
    <label for="description">Description:</label>
    <textarea id="description" name="description"><?php echo $product['description']; ?></textarea>
    <input type="submit" value="Update">
</form>

</body>
</html>