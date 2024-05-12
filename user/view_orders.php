<?php
session_start();

include '../config.php';

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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            overflow-x: auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            background-color: #5e34eb;
            border: none;
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 0px;
            cursor: pointer;
            width: 100px;
            margin: 20px 0px;

        }
        h1{
            text-align: center;
            margin-top: 10px ;
            font-weight: 900;
        }
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }
            th, td {
                font-size: 14px;
            }
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
                        <li><a href="/project-ecommerce/index.php">Home</a></li>
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
                                        echo "<a href='/project-ecommerce/user/view_orders.php' class='active'>View Orders</a>";
                                        echo "<a href='/user/change_password.php'>Change Password</a>";
                                        echo "<a href='/user/logout.php'>Logout</a>";
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

<body>
<h1><b>View Orders</b></h1>
<a href="../index.php" class="back-button">Go Back</a>

<?php
// Include necessary files and start the session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Function to group orders by user ID
function groupOrdersByUser($orders) {
    $groupedOrders = array();
    foreach ($orders as $order) {
        $userId = $order["user_id"];
        if (!isset($groupedOrders[$userId])) {
            $groupedOrders[$userId] = array();
        }
        $groupedOrders[$userId][] = $order;
    }
    return $groupedOrders;
}

// Establish database connection
$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Base URL where images are stored
$base_url = "../backend/uploads/";

// Prepare the query to select data from the "orders" table with product images for the current user
$stmt = $mysqli->prepare("SELECT orders.*, products.image AS product_image FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE user_id = ?");

// Bind parameters
$stmt->bind_param("i", $user_id);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if any rows are returned
if ($result->num_rows > 0) {
    // If there are rows, group them by user ID
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $groupedOrders = groupOrdersByUser($orders);

    // Display the orders in a table
    echo "<table id='tab'>";
    echo "<tr><th>Email</th><th>Contact</th><th>City</th><th>Address</th><th>Landmark</th><th>Price</th><th>Payment</th><th>Order Date</th><th>Quantity</th><th>Product Image</th><th>Remarks</th><th>Actions</th></tr>";

    foreach ($groupedOrders as $userId => $userOrders) {
        // Start a row for each user
        echo "<tr>";
        $firstOrder = true;
        foreach ($userOrders as $order) {
            // Set default remarks value to "Order Pending" if it's empty
            $remarks = !empty($order["remarks"]) ? $order["remarks"] : "Order Pending";

            // Check if remarks is "Cancelled" or "Completed" to hide the buttons
            $hideButtons = ($remarks === "Cancelled" || $remarks === "Completed") ? "style='display:none;'" : "";

            // Display other order details
            echo "<td>" . $order["email"] . "</td>";
            echo "<td>" . $order["contact"] . "</td>";
            echo "<td>" . $order["city"] . "</td>";
            echo "<td>" . $order["address"] . "</td>";
            echo "<td>" . $order["landmark"] . "</td>";
            echo "<td>" . $order["price"] . "</td>";
            echo "<td>" . $order["payment"] . "</td>";
            echo "<td>" . $order["order_date"] . "</td>";
            echo "<td>" . $order["quantity"] . "</td>";
            echo "<td><img src='" . $base_url . $order["product_image"] . "' alt='Product Image' style='width:100px;height:100px;'></td>";
            $statusColor = ($remarks === "Completed") ? "green" : "grey";
            echo "<td><span id='remarks_" . $order["id"] . "' style='color: " . $statusColor . ";'>" . $remarks . "</span></td>";

            echo "<td>";
            echo "<button id='cancelBtn_" . $order["id"] . "' onclick='cancelOrder(" . $order["id"] . ")' " . $hideButtons . ">Cancel Order</button>";
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    // If no rows are returned, display a message
    echo "No orders found.";
}

// Close the database connection
$mysqli->close();
?>

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
                        <td><a href="../policy.html">Privacy Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.instagram.com">Instagram</a></td>
                        <td><a href="../shipping.html">Shipping policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.viber.com">Viber</a></td>
                        <td><a href="../return.html">Return Policy</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.whatsapp.com">Whatsapp</a></td>
                        <td><a href="../terms.html">Terms & Conditions</a></td>
                    </tr>
                </table>    
            </div>
            <hr>
            <p class="copyright">© 2023 BagSales Nepal. All rights reserved. </p>
        </div>
    </div>

    <script src="../js/button.js"></script>
<!-- JavaScript for canceling orders -->
<script>
    function cancelOrder(orderId) {
        // Update remarks to "Order Cancelled"
        document.getElementById("remarks_" + orderId).innerText = "Order Cancelled";
        
        // Remove cancel button
        var cancelBtn = document.getElementById("cancelBtn_" + orderId);
        cancelBtn.style.display = "none";

        // Store in localStorage that the cancel button has been clicked
        localStorage.setItem("remarks_" + orderId, "Order Cancelled");

        // AJAX call to update order status to canceled
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cancel_order.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Optionally handle the response if needed
            }
        };
        xhr.send("orderId=" + orderId);
    }
    function completeOrder(orderId) {
        // Update remarks to "Order Completed"
        document.getElementById("remarks_" + orderId).innerText = "Order Completed";

        // Remove both buttons
        var cancelBtn = document.getElementById("cancelBtn_" + orderId);
        var completeBtn = document.getElementById("completeBtn_" + orderId);
        cancelBtn.parentNode.removeChild(cancelBtn);
        completeBtn.parentNode.removeChild(completeBtn);

        // Store in localStorage that the complete button has been clicked
        localStorage.setItem("remarks_" + orderId, "Order Completed");

        // AJAX call to update order status to completed
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "complete_order.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Optionally handle the response if needed
            }
        };
        xhr.send("orderId=" + orderId);
    }
    window.onload = function() {
        var orderIds = document.querySelectorAll("[id^='remarks_']");
        orderIds.forEach(function(order) {
            var orderId = order.id.split("_")[1];
            var remarks = localStorage.getItem("remarks_" + orderId);
            if (remarks) {
                document.getElementById("remarks_" + orderId).innerText = remarks;
                
                // If remarks exist and is "Cancelled" or "Completed", remove the buttons
                if (remarks === "Order Cancelled" || remarks === "Order Completed") {
                    var cancelBtn = document.getElementById("cancelBtn_" + orderId);
                    if (cancelBtn) {
                        cancelBtn.style.display = "none";
                    }
                    var completeBtn = document.getElementById("completeBtn_" + orderId);
                    if (completeBtn) {
                        completeBtn.style.display = "none";
                    }
                }
            }
        });
    }
</script>
</body>
</html>
