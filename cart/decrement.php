<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID from the form
    $product_id = $_POST['product_id'];

    // Decrement the quantity of the product
    $_SESSION['cart'][$product_id]['quantity']--;

    // If the quantity is 0 or less, remove the product from the cart
    if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Redirect to the cart page
header("Location: cart.php");
exit;
?>