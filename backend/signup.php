<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css" class="css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Sign Up - BagSalesNepal</title>
    
</head>
<body>
<div class="header">
        <div class="navcont">
            <div class="navbar">
                <div class="logo">
                    <a href="../index.html">
                        BagShopNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="../index.html" >Home</a></li>
                        <li><a href="../products.php">Products</a></li>
                        <li><a href="../about.html">About</a></li>
                        <li><a href="../contact.html">Contact</a></li>
                        <li><a href="../offers.html">Offers</a></li>
                        <li><a href="../login.php" >Login</a></li>
                        <li><a href="../signup.html" class="active">Signup</a></li>
                    </ul>
                </nav>
                <button id="hamburger-menu" class="hamburger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
            </div>
        </div>
    </div>

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
        echo '<h1 style="text-align: center; margin: 15px auto">New record created successfully<h1>';

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
        $mail->addAddress($email, $firstname . ' ' . $lastname);

        // Set the subject line
        $mail->Subject = 'Thank you for registering at Bag Sales Nepal';

        // Attach the logo
        $mail->AddEmbeddedImage('../images/logo.png', 'logo');

        // Set the body
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Dear $firstname,</h2>
            <p>Thank you for registering at Bag Sales Nepal. Here are your details:</p>
            <p>Name: $firstname $lastname</p>
            <p>Email: $email</p>
            <p>Phone Number: $number</p>
            <p>If you have any questions, feel free to contact us.</p>
            <p>Best,</p>
            <p>Bag Sales Nepal Team</p>
            <img src='cid:logo' alt='Logo' style='width: 300px; height: 70px;'><br>

        ";


        // Send the email
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '<h1 style="text-align: center; margin: 15px auto">Message sent!</h1>';
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    $conn->close();
}
?>
<!-- Footer -->

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download our App</h3>
                    <p>Download  App for Android and ios mobile phone.</p>
                    <div class="app-logo">
                        <img src="backend/uploads/play-store.png" alt="">
                        <img src="backend/uploads/app-store.png" alt="">
                    </div>
                </div>
                <div class="footer-col-2">
                    <h3>Newsletter</h3>
                    <form action="..../subscribe.php" method="post">
                        <input type="email" name="email" placeholder="Enter your email">
                        <button type="submit">Subscribe</button>
                    </form>
                    <p>Our purpose is to sustainably make the pleasure and benefits of Bags Accessible to many.</p>
                </div>
                <table border="0" cellspacing="10" cellpadding="10">
                    <tr>
                        <td><h3>Follow us:</h3></td>
                        <td><h3>Quick Links</h3></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.facebook.com">Facebook</a></td>
                        <td><a href="policy.html">Privacy Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.instagram.com">Instagram</a></td>
                        <td><a href="shipping.html">Shipping policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.viber.com">Viber</a></td>
                        <td><a href="return.html">Return Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.whatsapp.com">Whatsapp</a></td>
                        <td><a href="terms.html">Terms & Conditions</a></td>
                    </tr>
                </table>    
            </div>
            <hr>
            <p class="copyright">© 2023 BagShop Nepal. All rights reserved. </p>
        </div>
    </div>

    <script src="./js/button.js"></script>

    
</body>
</html>
