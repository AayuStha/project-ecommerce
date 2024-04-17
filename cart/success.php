<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../config.php';

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

    // Create a new PHPMailer instance
    $mail = new PHPMailer;

    // Set PHPMailer to use the sendmail transport
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bagsalesnepal@gmail.com';
    $mail->Password = 'msxk baxf frvh knou';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set who the message is to be sent from
    $mail->setFrom('bagsalesnepal@gmail.com', 'Bag Sales Nepal');

    // Set who the message is to be sent to
    $mail->addAddress($email);

    // Set the subject line
    $mail->Subject = 'Order Confirmation';

    // Set the body
    $mail->isHTML(true);
    $mail->Body = "
        <h2>Dear Customer,</h2>
        <p>Thank you for your order. Your order details are as follows:</p>
        <p>Contact: $contact</p>
        <p>City/District: $city</p>
        <p>Address: $address</p>
        <p>Landmark: $landmark</p>
        <p>Payment Method: $payment</p>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Best,</p>
        <p>Your Team</p>
    ";

    // Send the email
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<h1 style="text-align: center; margin: 15px auto">Message sent!</h1>';
    }

    // Redirect to the orders page
    header("Location: orders.php");
    exit;
} else {
    // Invalid request
    header("HTTP/1.0 400 Bad Request");
    exit;
}
?>