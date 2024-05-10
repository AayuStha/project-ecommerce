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
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
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
            width: 10%;
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

        .radio-group{
            display: flex;
            flex-direction: row;
        }

        .radio-group label{
            margin-bottom: -10px;
        }
        .radio-group input{
            margin-top:20px;
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
        // User is logged in, proceed to display the shipping details form

        include '../config.php';
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
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

        // Check if there are items in the cart
        if (!empty($_SESSION['cart'])) {
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
                
                <!-- Loop through the cart items to display their details -->
                <?php foreach ($_SESSION['cart'] as $product_id => $product_details) { ?>
                    <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                    <label for="quantity_<?php echo $product_id; ?>">Quantity for <?php echo $product_details['name']; ?>:</label>
                    <input type="number" name="quantity[]" id="quantity_<?php echo $product_id; ?>" value="<?php echo $product_details['quantity']; ?>" readonly> <br>
                    <label for="total_price_<?php echo $product_id; ?>">Total Price:</label>
<input type="number" name="total_price[]" id="total_price_<?php echo $product_id; ?>" value="<?php echo $product_details['quantity'] * $product_details['price']; ?>" readonly> <br>
                <?php } ?>

                <!-- Other form fields and payment method selection -->
                <h1>Please select your payment method</h1>
                <div class="radio-group">
                    <input type="radio" id="Cash on delivery" name="payment" value="Cash on delivery">
                    <label for="Cash on delivery">Cash on Delivery</label>
                </div>
                <input type="submit" value="Place order">
            </form>
            <?php
        } else {
            echo "Your cart is empty."; // Add your error message handling here
        }

    } else {
        // User is not logged in, redirect to login page
        header("Location: ../login.php");
        exit;
    }
    ?>
    <!-- footer -->
    <div class="footer">
        <div class="container">
            <!-- Footer content -->
        </div>
    </div>

    <script src="../js/button.js"></script>    
</body>
</html>
