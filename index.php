<?php
session_start();

include 'config.php';

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

    <link rel="stylesheet" href="/project-ecommerce/css/style.css" class="css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <title>Home - BagSales Nepal</title>
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
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.php">
                        BagSalesNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.php" class="active">Home</a></li>
                        <li><a href="/project-ecommerce/products.php" >Products</a></li>
                        <li><a href="/project-ecommerce/about.php">About</a></li>
                        <li><a href="/project-ecommerce/contact.php">Contact</a></li>
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
                                        echo "<a href='/project-ecommerce/user/change_password.php'>Change Password</a>";
                                        echo "<a href='/project-ecommerce/user/logout.php'>Logout</a>";
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

            </div>
            <hr id="hr">
            <br>
            <div class="row">
                <div class="col-2">
                        <h1>Carry in Style: <br> Unleash Your Bag Obsession</h1>
                        <p>Step into the world of fashion-forward bags. Discover our curated collection and find the perfect accessory to elevate your style.</p>
                        <a href="products.php" class="btn">Explore Now &#8594;</a>
                </div>
                <div class="col-2">
                        <a href="products.php" ><img src="images/demo8.png" alt="bag"></a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- featured products -->

    <div class="small-container">
        <h2 class="title">New Arrivals</h2>
        <p>Introducing our latest arrivals, where innovation meets style! Dive into our newest collection and discover the perfect blend of fashion-forward trends and timeless classics.</p>
            <div class="row">
                <div class="col-4">
                    <a href="/products/detail_four.html">
                    <img src="backend/uploads/demo.png" alt="hiii">
                    <h4>Acer School Bagpack</h4>
                    <p style="font-size: medium; text-align: left;">Rs 4500</p>
                </a>
                </div>
                <div class="col-4">
                    <img src="backend/uploads/demo1.png" alt="hiii">
                    <h4>Laptop bag</h4>
                    <p style="font-size: medium; text-align: left;">Rs 2000</p>
                </div>
                <div class="col-4">
                    <a href="/products/detail_two.html">
                        <img src="backend/uploads/demo12.png" alt="hiii">
                    <h4>Laptop bag</h4>
                    <p style="font-size: medium; text-align: left;">Rs 3500</p>
                </a>
                </div>
            </div>
            <a href="products.php" class="btn">View more</a>


            <h2 class="title">Features</h2>
            <p>Features meticulously designed to redefine comfort and style. Crafted with precision, each bag is a testament to innovation and functionality.</p>
            <div class="row">
                <div class="feature-item">
                    <br>
                    <img src="images/quality.png" alt="quality">
                    <br>
                    <h3>Quality</h3>
                    <p style="font-size: small;">Quality is at the heart of everything we offer. From meticulously sourced materials to rigorous manufacturing standards, we prioritize excellence to ensure each product meets your highest expectations. Shop with confidence, knowing that every item is crafted with durability, functionality, and style in mind.</p>
                </div>
                <div class="feature-item">
                    <br>
                    <img src="images/versatile.png" alt="versatile">
                    <br>
                    <h3>Versatile</h3>
                    <p style="font-size: small;">Embrace versatility with our products designed for your dynamic lifestyle. Whether you're at work, leisure, or on the go, our flexible offerings seamlessly adapt to your needs. Experience the freedom to customize, adjust, and utilize our versatile products in countless ways, empowering you to navigate life with ease and style.</p>
                </div>
                <div class="feature-item">
                    <br>
                    <img src="images/longlasting.png" alt="long-lasting"><br>
                    <h3>Long Lasting</h3>
                    <p style="font-size: small;">Experience enduring quality with our long-lasting products built to withstand the test of time. Crafted from premium materials and engineered with precision, our items promise durability that goes beyond expectations. Invest in reliability and sustainability, ensuring your satisfaction for years to come.</p>
                </div>
            </div>
    </div>

    <!-- Offer -->
    
    <div class="offer">
        <div class="small-container">
            <h2 class="title">Exclusive Offers!!!</h2>
            <div class="row">
                <div class="col-2">
                    <img src="backend/uploads/demo.png" alt="hiii">

                </div>
                <div class="col-2" data-aos="fade-left">
                    Exclusively available on BagSales Nepal
                    <h1>Laptop Bag</h1>
                    <small>Elevate your work style with our sleek and durable laptop bags, designed for both fashion and function. Stay organized and professional on the go.</small>
                    <br>
                    <a href="offers.php" class="btn">Shop Now &#8594</a>
                </div>
            </div>
        </div>
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
            <hr>
            <p class="copyright">© 2023 BagSales Nepal. All rights reserved. </p>
        </div>
    </div>

    <script src="./js/button.js"></script>
    <script>

    var urlParams = new URLSearchParams(window.location.search);


    if (urlParams.has('message')) {

        alert(urlParams.get('message'));
    }
</script>


    
</body>
</html>