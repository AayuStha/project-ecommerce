<?php
    include './config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = htmlspecialchars($_POST["email"]); // Use htmlspecialchars to prevent XSS attacks
        $usr_password = htmlspecialchars($_POST["usr_password"]); // Use htmlspecialchars to prevent XSS attacks

        $mysqli = new mysqli($servername, $username, $password, $database);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare("SELECT id, usr_password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;

        if ($num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();
        
            if (password_verify($usr_password, $hashed_password)) {
                // The password is correct. Start a session and store the user's ID in the session.
                session_start();
                $_SESSION['user_id'] = $id;
                // Redirect the user to the home page.
                header('Location: /project-ecommerce/user/home.php');
                exit;
            } else {
                // The password is incorrect.
                $error ='Invalid password.';
            }
        } else {
            // The email is invalid.
            $error = 'Invalid email.';
        }
        $stmt->close();
        $mysqli->close();
    } 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../project-ecommerce/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title>BagShop Nepal</title>
    <style>

    .navcont{
        max-width: 1300px;
        margin: auto;
        padding-left: 25px;
        padding-right: 25px;
    }
        .form-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 90%;
        margin-left: 100px;
    }

    img {
        flex: 1;
        max-width: 40%;
        height: auto;

    }

    .login-form {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        width: 400px;
        border: 2px solid #5f5f5f;
        margin: 20px 90px 20px 200px;
    }

    .login-form h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-form input {
        width: 95%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .login-form button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #af0505;
        color: #fff;
        cursor: pointer;
    }

    .login-form button:hover {
        background-color: #0056b3;
    }

    @media screen and (max-width: 500px) {
        .form-container {
            flex-direction: column;
            margin-left: 20px;
        }
        img{
            max-width: 90%;
            max-height: 400px;
            object-fit: cover;
        }
        .login-form {
            margin: 20px 0;
            width: 100%;

        }
        .login-form{
            width:70%;
        }
        .error{
            color: #af0505;
        }
    }
    </style>
</head>
<body>
    <div class="header">
        <div class="navcont">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.html">
                        BagShopNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.html" >Home</a></li>
                        <li><a href="/project-ecommerce/products.php">Products</a></li>
                        <li><a href="/project-ecommerce/about.html">About</a></li>
                        <li><a href="/project-ecommerce/contact.html">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.html">Offers</a></li>
                        <li><a href="/project-ecommerce/backend/contact.php" class="active">Login</a></li>
                        <li><a href="/project-ecommerce/signup.html">Signup</a></li>
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
    <div class="form-container">
        <img src="/project-ecommerce/images/login.jpg" alt="login image">
        <form class="login-form" method="POST" action="./login.php">
            <h2>Login</h2>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="usr_password" name="usr_password" required>
            <a href="#" class="forgot-password">Forgot password?</a>
            <button type="submit">Login</button>
            <br>
            <br>
            <p class="signup-text">Don't have an account? <a href="./signup.html">Sign up</a></p>
            <?php
    if(isset($error)) {
        echo '<div class="error">' . $error . '</div>';
    }
    ?>
        </form>
        
    </div>
    
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
            <br>
            <hr>
            <p class="copyright">© 2023 BagShop Nepal. All rights reserved. </p>
        </div>
    </div>

    <script src="./js/button.js"></script>

    
</body>
</html>