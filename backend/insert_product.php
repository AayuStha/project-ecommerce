<?php
include '../config.php';
$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$name = $_POST['name'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$description = $_POST['description'];

if (is_uploaded_file($_FILES['image']['tmp_name'])) {

    $upload_dir = 'uploads/';

    $upload_file = $upload_dir . basename($_FILES['image']['name']);


    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {

        $stmt = $db->prepare("INSERT INTO products (name, price, rating, description, image) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $name, $price, $rating, $description, basename($_FILES['image']['name']));

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

