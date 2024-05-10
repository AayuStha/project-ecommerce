<?php
session_start(); // Start the session if it's not already started

// Check if the admin is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: ./admin_login.php');
    exit();
}
include '../config.php';
$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];

if (is_uploaded_file($_FILES['image']['tmp_name'])) {

    $upload_dir = 'uploads/';

    $upload_file = $upload_dir . basename($_FILES['image']['name']);


    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {

        $stmt = $db->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");

        $stmt->bind_param("ssss", $name, $price, $description, basename($_FILES['image']['name']));

        if ($stmt->execute()) {

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

