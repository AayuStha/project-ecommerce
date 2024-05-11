<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
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
            margin: 4px 2px;
            cursor: pointer;
            width: 120px;
            margin: 20px 0px;

        }
        h1{
            text-align: center;
            margin-top: -30px ;
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
    </style>
</head>
<body>
<a href="./home.php" class="back-button">Go Back</a>
<h1><b>View Orders</b></h1>

<?php
// Include necessary files and start the session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
include '../config.php';
session_start();

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
    echo "<table>";
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
            echo "<td><span id='remarks_" . $order["id"] . "' style='color: grey;'>" . $remarks . "</span></td>";
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
