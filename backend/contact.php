<?php
session_start();

include '../config.php';

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
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
    <style>
        .username {
        color: #cd34ef;
        font-size: 18px;
        font-family: 'Comic Sans Ms';
    }
    .user-name:hover {
    cursor: pointer;
    }

    .dropdown {
        position: relative;
        display: inline-block;
}

    .dropdown-content {
        display: none;
        position: absolute;
        margin-top: 10px;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        background-color: radial-gradient(#f4eef2,#f4eef2);;

    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropbtn {
        color: crimson;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .fa-caret-down {
        margin-left: 5px;
    }
    
    </style>
</head>
<body>
<div class="header">
        <div class="navcont">
            <div class="navbar">
                <div class="logo">
                    <a href="../index.php">
                        BagSalesNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.php">Home</a></li>
                        <li><a href="/project-ecommerce/products.php" >Products</a></li>
                        <li><a href="/project-ecommerce/about.php">About</a></li>
                        <li><a href="/project-ecommerce/contact.php" class="active">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.php">Offers</a></li>
                        <?php
                            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                                $query = "SELECT firstname FROM users WHERE id = {$_SESSION['user_id']}";
                                $result = mysqli_query($connection, $query);
                                
                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    if ($row) {
                                        $firstName = $row['firstname'];
                                        echo "<li class='dropdown'>";
                                        $greetings = array("Howdy", "Hello", "Hi", "Greetings", "Hey");
                                        $randomGreeting = $greetings[array_rand($greetings)];
                                        echo "<a href='#' class='dropbtn'>$randomGreeting, $firstName <i class='fa fa-caret-down'></i></a>";
                                        echo "<div class='dropdown-content'>";
                                        echo "<a href='/project-ecommerce/user/view_orders.php'>View Orders</a>";
                                        echo "<a href='/user/change_password.php'>Change Password</a>";
                                        echo "<a href='/user/logout.php'>Logout</a>";
                                        echo "</div></li>";
                                    } else {
                                        echo '<li><a href="/project-ecommerce/login.php">Login</a></li>';
                                        echo '<li><a href="/project-ecommerce/signup.html">Signup</a></li>';
                                    }
                                } else {
                                    echo "ERROR: Could not execute $query. " . mysqli_error($connection);
                                }
                            } else {
                                echo '<li><a href="/project-ecommerce/login.php">Login</a></li>';
                                echo '<li><a href="/project-ecommerce/signup.html">Signup</a></li>';
                            }
                        ?>
                        <a href="/project-ecommerce/cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $conn = new mysqli($servername, $username, $password, $database);
            
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO contactForm (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        echo '<h1 style="text-align: center; margin: 150px auto">Thank you for contacting us.<h1>';

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
                        <img src="../backend/uploads/play-store.png" alt="">
                        <img src="../backend/uploads/app-store.png" alt="">
                    </div>
                </div>
                <div class="footer-col-2">
                    <h3>Newsletter</h3>
                    <form action="../subscribe.php" method="post">
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
                        <td><a href="../policy.html">Privacy Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.instagram.com">Instagram</a></td>
                        <td><a href="../shipping.html">Shipping policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.viber.com">Viber</a></td>
                        <td><a href="../return.html">Return Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.whatsapp.com">Whatsapp</a></td>
                        <td><a href="../terms.html">Terms & Conditions</a></td>
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
