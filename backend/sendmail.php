<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $usr_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $conn = new mysqli($servername, $username, $password, $database);
            
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, number, usr_password) VALUES (?, ?, ?, ?, ?)");

    $hashed_password = password_hash($usr_password, PASSWORD_DEFAULT);

    $stmt->bind_param("sssss", $firstname, $lastname, $email, $number, $hashed_password);

    if ($stmt->execute()) {
        echo "<h1>New record created successfully<h1>";

        // Create a new PHPMailer instance
        $mail = new PHPMailer;

        // Set PHPMailer to use the sendmail transport
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'a.ius.xtha@gmail.com';
        $mail->Password = 'msxk baxf frvh knou';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set who the message is to be sent from
        $mail->setFrom('a.ius.xtha@gmail.com', 'BagShop Nepal');

        // Set who the message is to be sent to
        $mail->addAddress($email, $firstname . ' ' . $lastname);

        // Set the subject line
        $mail->Subject = 'Thank you for registering at BagShop Nepal';

        // Set the body
        $mail->Body = "Dear $firstname,

        Thank you for registering at BagShop Nepal. Here are your details:

        Name: $firstname $lastname
        Email: $email
        Phone Number: $number

        If you have any questions, feel free to contact us.

        Best,
        BagShop Nepal Team";

        // Send the email
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    $conn->close();
}

