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
                        <li><a href="/login.php">Login</a></li>
                        <li><a href="/signup.html">Signup</a></li>
                    </ul>
                </nav>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
            </div>
            <hr>
            <br>
            <div class="row">
                <div class="col-2">
                        <h1>Carry in Style: <br> Unleash Your Bag Obsession</h1>
                        <p>Step into the world of fashion-forward bags. Discover our curated collection and find the perfect accessory to elevate your style.</p>
                        <a href="products.html" class="btn">Explore Now &#8594;</a>
                </div>
                <div class="col-2">
                        <a href="products/detail_three.html"><img src="images/demo8.png" alt="bag"></a>
                </div>
            </div>
        </div>
    </div>

    <form class="signup-form" method="POST">
        <h2>Sign Up</h2>
        <div class="name-field">
            <input type="text" name="firstname" placeholder="First Name" required> 
            <input type="text" name="lastname" placeholder="Last Name" required> 
        </div>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="number" placeholder="Number" required>
        <input type="password" name="password" placeholder="Create Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">By clicking Sign Up, you agree to our <a href="./terms.html">Terms</a> and that you have read our <a href="./policy.html">Privacy Policy</a></label>
        <button type="submit" id="signup-button">Sign Up</button>
        <p>Already have an account? <a href="./login.php">Log in</a>.</p>
    </form>

    <?php
    include 'config.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $number = $_POST["number"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if ($password != $confirm_password) {
            echo "<h2>Passwords do not match</h2>";
            exit;
        }

        $mysqli = new mysqli($servername, $username, $password, $database);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare("INSERT INTO Users (firstname, lastname, email, number, password) VALUES (?, ?, ?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $number, $hashed_password);


        if ($stmt->execute()) {
            echo "<h2>Account creation successfully</h2>";
        } else {
            echo "<h2>Error: " . $stmt->error;
        }


        $stmt->close();
        $mysqli->close();
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