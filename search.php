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
    <title>Search - BagSales Nepal</title>
    <style>
    .product img {
        width: 30%;
        height: auto;
        object-fit: cover;
    }

    .product {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #else{
        font-size: 20px;
    }
    h1{
        font-size: 20px;
    }
    .row-2{
        margin-top: 25px;
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
        </div>
    </div>
    <div class="small-container">
        <div class="row row-2">
            <h2>Searched Items:</h2>
        </div>


        <?php
        // Connect to the database
        include 'config.php';

        $db = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Get the search query
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Prepare the SQL query
        $sql = "SELECT * FROM products";
        if ($search !== '') {
            $sql .= " WHERE name LIKE ?";
        }

        // Prepare the statement
        $stmt = $db->prepare($sql);

        // Bind the parameters
        if ($search !== '') {
            $search = '%' . $search . '%';
            $stmt->bind_param('s', $search);
        }

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Output each product
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<a href='product_detail.php?id=" . $row["id"] . "'>";
                echo "<img src='backend/uploads/" . $row["image"] . "' width='50'' alt='Product Image'>";
                echo "<h4>" . $row["name"] . "</h4>";
                echo "<h1> Rs " . $row["price"]. "</h1>";
                echo "</a>";
                echo "</div><br><br>";
            }
        } else {
            echo "<h3><p><b>No products found</b></p></h3>";
            echo "<br><br>";
        }

        $stmt->close();
        $db->close();
        ?>

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