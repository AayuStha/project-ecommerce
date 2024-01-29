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
    
    <title>All Products - BagShop Nepal</title>
</head>
<body>
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/index.html">
                        <img src="/images/logo.png" width="125px"alt="logo">
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="products.html" class="active">Products</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="offers.html">Offers</a></li>
                    </ul>
                </nav>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
                
            </div>
            </div>
        </div>
        <hr>
    <div class="small-container">
        <div class="row row-2">
            <h2>All Products</h2>
            <!-- <select>
                <option>Default</option>
                <option>High to Low</option>
                <option>Low to High</option>

            </select> -->
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
            echo "<a href='products/detail_one.html'>";
            echo "<img src='backend/uploads/" . $row["image"] . "' width='100'' alt='Product Image'>";
            echo "<h4>" . $row["name"] . "</h4>";
            echo "<div class='rating'>";
            for ($i = 0; $i < $row["rating"]; $i++) {
                echo "<i class='fa-solid fa-star'></i>";
            }
            for ($i = $row["rating"]; $i < 5; $i++) {
                echo "<i class='fa-regular fa-star'></i>";
            }
            echo "</div>";
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
            <p class="copyright">© 2023 BagShop Nepal. All rights reserved. </p>
        </div>
    </div>
    
</body>
</html>