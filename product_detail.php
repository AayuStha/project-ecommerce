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
    img {
        width: 250px;
        height: fixed;
        flex: 1;
    }
    h1 {
        font-size: 2em;
        color: #333;
    }
    p {
        font-size: 1.2em;
        color: #666;
    }
    .price {
        font-size: 1.5em;
        color: green;
    }
    form {
    display: flex;
    align-items: center;
    }

    input[type="text"] {
    width: 50px;
    margin-top: 30px;
    text-decoration: none;
    text-align: center;
    background: transparent;
    }
    #btn{
        border: none;
        width: 40px;
        height: 45px;
        background-color: radial-gradient(#f4eef2,#f4eef2);
    }
    .addtocart-btn {
    background-color: green;
    border: none;
    color: #333;
    padding: 10px 30px;
    width: 200px;
    height: 50px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 29px;
    margin-left: 15px;
    cursor: pointer;
}
    @media screen and (max-width: 510px){   
        h1{
            margin-left: 6px;
        }
    }
</style>

</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="/project-ecommerce/index.html">
                        BagShopNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="/project-ecommerce/index.html" >Home</a></li>
                        <li><a href="/project-ecommerce/products.php" class="active">Products</a></li>
                        <li><a href="/project-ecommerce/about.html">About</a></li>
                        <li><a href="/project-ecommerce/contact.html">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.html">Offers</a></li>
                        <li><a href="/project-ecommerce/login.php">Login</a></li>
                        <li><a href="/project-ecommerce/signup.html">Signup</a></li>
                    </ul>
                </nav>
                <!-- <img src="images/cart.png" width="30px" height="30px"alt="cart"> -->
            </div>
            <hr>
            <br>
            <?php
                // Connect to the database
                include 'config.php';

                $db = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                // Get the ID of the product
                $id = $_GET['id'];

                // Fetch the product data
                $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();
                ?>

                <!-- Display the product data -->
                <img src="backend/uploads/<?php echo $product['image']; ?>" alt="Product Image">
                <h1><?php echo $product['name']; ?></h1>
                <p><?php echo $product['description']; ?></p>
                <br>
                <p class="price">Price: 🇳🇵 <?php echo $product['price']; ?></p>
                <br>
                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="button" onclick="decrementValue()" id="btn">-</button>
                    <input type="text" name="quantity" value="1" id="number">
                    <button type="button" onclick="incrementValue()"id="btn">+</button>
                    <a href="/project-ecommerce/cart.php"><button class="addtocart-btn">Add to Cart</button></a>
                </form>
                <br>
                <br>
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
            <p class="copyright">© 2023 BagShop Nepal. All rights reserved. </p>
        </div>
    </div>
    <script>
        function incrementValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('number').value = value;
}

function decrementValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('number').value = value;
}
    </script>
</body>
</html>