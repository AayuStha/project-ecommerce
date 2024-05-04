
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href=".././css/style.css" class="css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Checkout - BagSales Nepal</title>
    <style>
        h1{
            text-align: left;
            font-weight: 200;
            font-size: 25px;
        }
        body {
            font-family: Arial, sans-serif;
        }

        #form {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            width: 400px;
            border: 2px solid #5f5f5f;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-top: 20px;
        }

        input[type="text"], input[type="email"], input[type="number"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="radio"] {
            float: left;
            margin-right: 10px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="../index.html">
                        BagSalesNepal
                    </a>
                </div>
                <nav>
                    <ul id="items">
                        <li><a href="../index.html" class="active">Home</a></li>
                        <li><a href="../products.php">Products</a></li>
                        <li><a href="../about.html">About</a></li>
                        <li><a href="../contact.html">Contact</a></li>
                        <li><a href="../offers.html">Offers</a></li>
                        <li><a href="../login.php">Login</a></li>
                        <li><a href="../signup.html">Signup</a></li>
                        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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
    <br>
    <?php
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == true) {
        if(isset($_POST['product'])){
            $product = $_POST['product'];
        }
        // User is logged in, proceed to display the shipping details form

        include '../config.php';
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

         // Fetch the user's email from the database
        $user_id = $_SESSION['user_id'];
        $query = "SELECT email, number FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $email = $user['email'];
        $contact = $user['number'];
    ?>
    <form action="./orders.php" method="post" id="form">
        <h1>Please enter your shipping details</h1>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required> <br>
        <label for="contact">Contact:</label>
        <input type="number" id="contact" name="contact" value="<?php echo $contact; ?>" required> <br> 
        <label for="city">City/District:</label>
        <input type="text" id="city" name="city" required> <br> 
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required> <br> 
        <label for="landmark">Landmark:</label>
        <input type="text" id="landmark" name="landmark"> <br> 
        <br> <br>
        <h1>Please select your payment method</h1>
        <input type="radio" id="cod" name="payment" value="cod">
        <label for="cod">Cash on Delivery</label><br>
        <input type="radio" id="esewa" name="payment" value="esewa">
        <label for="esewa">Esewa</label><br>
        <input type="submit" value="Place order">
    </form>

    <!-- footer -->
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
                <table id="footer" border="0" cellspacing="10" cellpadding="10">
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

    <script src="../js/button.js"></script>    
</body>
</html>


<?php
} else {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit;
}
?>
