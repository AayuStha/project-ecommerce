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
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.html">
                        BagSalesNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.html" class="active">Home</a></li>
                        <li><a href="/project-ecommerce/products.php">Products</a></li>
                        <li><a href="/project-ecommerce/about.html">About</a></li>
                        <li><a href="/project-ecommerce/contact.html">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.html">Offers</a></li>
                        <li><a href="/project-ecommerce/login.html">Login</a></li>
                        <li><a href="/project-ecommerce/signup.html">Signup</a></li>
                        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </ul>
                </nav>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
            </div>
        </div>
        <hr>
    </div>
    <br>
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
                echo "<div class='rating'>";
                for ($i = 0; $i < $row["rating"]; $i++) {
                    echo "<i class='fa-solid fa-star'></i>";
                }
                for ($i = $row["rating"]; $i < 5; $i++) {
                    echo "<i class='fa-regular fa-star'></i>";
                }
                echo "</div>";
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