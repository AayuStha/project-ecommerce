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

    <link rel="stylesheet" href="css/style.css" class="css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <title>All Products - BagSales Nepal</title>
    <style>
    .searchbox{
        position: relative;
    }
    .input {
        width: 50px;
        height: 50px;
        background: none;
        border: 3px solid black;
        border-radius: 50px;
        box-sizing: border-box;
        font-size: 26px;
        color: black;
        outline: none;
        transition: .5s;
    }
    .searchbox:hover input{
        width: 200px;
        background: white;
        border-radius: 50px;
    }
    .searchbox i{
        position: absolute;
        top: 50%;
        right: 6px;
        transform: translate(-50%,-50%);
        font-size: 20px;
        color: black;
        transition: .2s;
    }
    .searchbox:hover i{
        opacity: 0;
        z-index: -1;
    }
    h1{
        font-size: 20px;
    }

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
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.php">
                        BagSalesNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.php">Home</a></li>
                        <li><a href="/project-ecommerce/products.php" class="active">Products</a></li>
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
                <!-- <a href="/project-ecommerce/cart.php"><img src="/project-ecommerce/backend/uploads/cart.png" width="30px" height="30px"alt="cart"></a> -->
            </div>
        </div>
        <hr>
    <div class="small-container">
        <div class="row row-2">
            <h2>All Products</h2>
            <div class="searchbox">
                <form name="search" action="search.php" method="get">
                    <input type="text" class="input" name="search" onmouseout="this.value = ''; this.blur();">
                </form>
                <i class="fas fa-search"></i>

            </div>
        </div>

        
        <div class="row">
    <?php
    // Connect to the database
    include 'config.php';

    $db = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    // Fetch products from the database
    $sql = "SELECT * FROM products";
    $result = $db->query($sql);
    

    if ($result->num_rows > 0) {
        // Output each product
        while($row = $result->fetch_assoc()) {
            echo "<div class='col-4'>";
            echo "<a href='product_detail.php?id=" . $row["id"] . "'>";
            echo "<img src='backend/uploads/" . $row["image"] . "' width='100'' alt='Product Image'>";
            echo "<h4>" . $row["name"] . "</h4>";
            echo "<h1> Rs " . $row["price"]. "</h1>";
            echo "</a>";
            echo "</div>";

        }
    } else {
        echo "<p>No products found</p>";
    }
    ?>
</div>
            <!-- <div class="page-btn">
                <span>1</span>
                <span>2</span>
                <span>3</span>
                <span>&#8594;</span>
            </div> -->
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

    
</body>
</html>