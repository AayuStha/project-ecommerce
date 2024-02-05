<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css" class="css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title>BagShop Nepal</title>

    <style>
        h2{
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/index.html">
                        BagShopNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/index.html" class="active">Home</a></li>
                        <li><a href="/project-ecommerce/products.php">Products</a></li>
                        <li><a href="/about.html">About</a></li>
                        <li><a href="/contact.html">Contact</a></li>
                        <li><a href="/offers.html">Offers</a></li>
                        <li><a href="/backend/contact.php">Login</a></li>
                        <li><a href="/signup.html">Signup</a></li>
                    </ul>
                </nav>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
            </div>
        </div>
    </div>
    <br>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $email = $_POST["email"];

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        include 'config.php';

                        // Create a new mysqli instance
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check the connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Prepare the SQL statement
                        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
                        $stmt->bind_param("s", $email);

                        // Execute the SQL statement
                        if ($stmt->execute()) {
                            echo "<h2>Thank you for subscribing!</h2>";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        // Close the statement and the connection
                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "Invalid email address.";
                    }
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
                    <form action="../project-ecommerce/subscribe.php" method="post">
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
    
</body>
</html>