<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID from the form
    $product_id = $_POST['product_id'];

    // Increment the quantity of the product
    $_SESSION['cart'][$product_id]['quantity']++;
}

// Redirect to the cart page
header("Location: cart.php");
exit;
?>