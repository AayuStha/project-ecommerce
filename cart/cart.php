<?php
session_start();
include '../config.php';

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch the product data from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Add the product to the cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'quantity' => $quantity,
        'price' => $product['price'],
        'image' => "../backend/uploads/" . $product['image'],
    ];
}

$totalPrice = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
}
?>

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
    <title>Cart - BagSales Nepal</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        img {
            width: 90px;
            height: 90px;
        }
        #para{
            margin: 100vw;
            font-size: 30px;
            font-weight: 800;
            text-align: center;
        }
        #checkout{
            display: block;
            width: 10%;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 50px;
            padding-top: 20px ;
            padding-bottom: 40px;
            padding-left: 12px;
            padding-right: 15px;
            font-size: 18px; 
            
        }

        input[type="submit"] {
            background-color: #4CAF50; 
            color: white; 
            padding: 1px 2px; 
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; 
        }

        input[type="submit"]:hover {
            background-color: #45a049; 
        }

        .num {
            text-align: center;
            font-size: 25px;
        }

        /* For tablets */
        @media (max-width: 768px) {
            table {
                width: 90%;
            }
            input[type="submit"] {
                padding: 5px 10px;
                font-size: 14px;
            }
            #checkout {
                width: 20%;
                font-size: 16px;
            }
        }

        /* For mobile phones */
        @media (max-width: 480px) {
            table {
                width: 80%;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
            }
            input[type="submit"] {
                padding: 5px 10px;
                font-size: 12px;
            }
            #checkout {
                width: 30%;
                font-size: 14px;
            }
        }

        .remove{
            border: none;
        }
        #total-price{
            text-align: center;
            font-family: 'Comic Sans Ms';
            margin-top: 90px;
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
                        <li><a href="project-ecommerce/contact.html">Contact</a></li>
                        <li><a href="/project-ecommerce/offers.html">Offers</a></li>
                        <li><a href="/project-ecommerce/login.php">Login</a></li>
                        <li><a href="/project-ecommerce/signup.html">Signup</a></li>
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

    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td ><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="num">
                        <?php echo htmlspecialchars($item['quantity']); ?>
                        <form method="POST" action="./increament.php">
                            <input type="hidden" name="product_id" value="<?php echo array_search($item, $_SESSION['cart']); ?>">
                            <input type="submit" value="+">
                        </form>
                        <form method="POST" action="./decrement.php">
                            <input type="hidden" name="product_id" value="<?php echo array_search($item, $_SESSION['cart']); ?>">
                            <input type="submit" value="-">
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                    <td class="remove">
                        <form method="POST" action="./remove.php">
                            <input type="hidden" name="product_id" value="<?php echo array_search($item, $_SESSION['cart']); ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div id="total-price">
            <h2>Total price till now: <?php echo $totalPrice; ?></h2>
        </div>

        <form method="post" action="./checkout.php">
            <input type="hidden" name="product" value="your_product">
            <button id="checkout" type="submit" name="checkout">Checkout</button>
        </form>
    <?php else: ?>
        <p id="para">Your cart is empty.</p>
    <?php endif; ?>

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