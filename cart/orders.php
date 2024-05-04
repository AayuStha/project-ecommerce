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
    // Get the form data
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $landmark = $_POST['landmark'];
    $payment = $_POST['payment'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the order into the database
    $query = "INSERT INTO orders (user_id, email, contact, city, address, landmark, payment) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssss", $_SESSION['user_id'], $email, $contact, $city, $address, $landmark, $payment);
    $stmt->execute();

    // Get the ID of the last inserted order
    $order_id = $conn->insert_id;

    // Initialize the total price
    $total_price = 0;

    // Build the order details string for the email
    $order_details = "";
    foreach ($_SESSION['cart'] as $item) {
        $order_details .= "<p><b>Product:</b> {$item['name']} -  {$item['quantity']}</p> ";
        $order_details .= "<p><b>Price:</b> {$item['price']}</p> <br>";

        // Update the total price
        $total_price += $item['price'] * $item['quantity'];
    }

    // Add the total price to the order details
    $order_details .= "<p><b>Total Price:</b> {$total_price}</p> <br>";

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
        <p>Thank you for your order. Your order number is {$order_id}. Your order details are as follows:</p>
        {$order_details}
        <p>Contact: $contact</p>
        <p>City/District: $city</p>
        <p>Address: $address</p>
        <p>Landmark: $landmark</p>
        <p>Payment Method: $payment</p>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Best,</p>
        <p>BagSalesNepal's Team</p>
    ";

    if(!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        header("Location: ../user/home.php?message=Order placed successfully");
    }
}