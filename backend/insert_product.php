<?php
// Connect to the database
include '../config.php';
$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// Get product data from the form
$name = $_POST['name'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$description = $_POST['description'];

// Check if file was uploaded
if (is_uploaded_file($_FILES['image']['tmp_name'])) {
    // Define the upload directory
    $upload_dir = 'uploads/';

    // Define the upload file path
    $upload_file = $upload_dir . basename($_FILES['image']['name']);

    // Move the uploaded file to the upload directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
        // Prepare an SQL statement
        $stmt = $db->prepare("INSERT INTO products (name, price, rating, description, image) VALUES (?, ?, ?, ?, ?)");

        // Bind the form data to the SQL statement
        $stmt->bind_param("sssss", $name, $price, $rating, $description, basename($_FILES['image']['name']));

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Redirect back to admin_panel.php
            header('Location: admin_panel.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: Failed to upload file.";
    }
} else {
    echo "Error: No file uploaded.";
}

?>