<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $landmark = $_POST['landmark'];
    $payment = $_POST['payment'];
    $product_ids = $_POST['product_id']; // Getting array of product IDs
    $quantities = $_POST['quantity']; // Getting array of quantities
    $total_price = $_POST['total_price'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize the total quantity
    $totalQuantity = 0;

    // Insert each product into the orders table
    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = $quantities[$i];
        $price = $total_price[$i];

        // Calculate the total quantity
        $totalQuantity += $quantity;

        // Insert the order into the database
        $query = "INSERT INTO orders (user_id, product_id, email, contact, city, address, landmark, quantity, price, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisssssiss", $_SESSION['user_id'], $product_id, $email, $contact, $city, $address, $landmark, $quantity, $price, $payment);
        $stmt->execute();
    }

    // Get the ID of the last inserted order
    $order_id = $conn->insert_id;

    $mail = new PHPMailer;

    // Configure the PHPMailer settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bagsalesnepal@gmail.com';
    $mail->Password = 'uxot hmnr ohax ifpu'; // Use your App Password here, without spaces
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('bagsalesnepal@gmail.com', 'Bag Sales Nepal');
    $mail->addAddress($email); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Order Confirmation';
    $mail->Body = "
        <h2>Dear Customer,</h2>
        <p>Thank you for your order. Your order number is {$order_id}. Your order details are as follows:</p>";

    // Loop through each product to add its details to the email body
    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = $quantities[$i];
        $price = $total_price[$i];

        $mail->Body .= "
            <p><b>Product ID:</b> {$product_id}</p>
            <p><b>Quantity:</b> {$quantity}</p>
            <p><b>Price:</b> {$price}</p><br>";
    }

    $mail->Body .= "
        <p><b>Total Quantity:</b> {$totalQuantity}</p>
        <p><b>Contact:</b> {$contact}</p>
        <p><b>City/District:</b> {$city}</p>
        <p><b>Address:</b> {$address}</p>
        <p><b>Landmark:</b> {$landmark}</p>
        <p><b>Payment Method:</b> {$payment}</p>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Best Regards,</p>
        <p>BagSalesNepal's Team</p>
    ";

    if(!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // Clear the cart
        $_SESSION['cart'] = array();

        // Redirect to the home page and show a message
        header("Location: ../index.php?message=Order placed successfully");
    }
}
?>
