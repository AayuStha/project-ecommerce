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
                        <li><a href="/backend/contact.php">Login</a></li>
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

    <div class="center-container">
        <div class="login-container">
            <form class="login-form" method="POST" action="./login.php">
                <h2>Login</h2>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <a href="#" class="forgot-password">Forgot password?</a>
                <button type="submit">Login</button>
                <p class="signup-text">Don't have an account? <a href="./signup.html">Sign up</a></p>
            </form>
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
    
</body>
</html>