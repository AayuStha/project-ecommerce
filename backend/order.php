<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
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
        }
    </style>
</head>
<body>
<a href="javascript:history.back()" class="back-button">Go Back</a>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../config.php';

session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code to process the order
}

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Base URL where images are stored
$base_url = "uploads/";

// Prepare the query to select data from the "orders" table with product images
$stmt = $mysqli->prepare("SELECT orders.*, products.image AS product_image FROM orders LEFT JOIN products ON orders.product_id = products.id");

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
    echo "<tr><th>Order ID</th><th>User ID</th><th>Email</th><th>Contact</th><th>City</th><th>Address</th><th>Landmark</th><th>Price</th><th>Payment</th><th>Order Date</th><th>Quantity</th><th>Product Image</th><th>Remarks</th><th>Actions</th></tr>";

    foreach ($groupedOrders as $userId => $userOrders) {
        // Start a row for each user
        echo "<tr>";
        $firstOrder = true;
        foreach ($userOrders as $order) {
            // Set default remarks value to "Order Pending" if it's empty
            $remarks = !empty($order["remarks"]) ? $order["remarks"] : "Order Pending";

            if (!$firstOrder) {
                // Skip user ID for subsequent orders from the same user
                echo "<td></td>";
            } else {
                // Display user ID for the first order from the user
                echo "<td>" . $order["user_id"] . "</td>";
                $firstOrder = false;
            }
            // Display other order details
            echo "<td>" . $order["id"] . "</td>";
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
            echo "<button id='cancelBtn_" . $order["id"] . "' onclick='cancelOrder(" . $order["id"] . ")'>Cancel Order</button>";
            echo "<button id='completeBtn_" . $order["id"] . "' onclick='completeOrder(" . $order["id"] . ")'>Order Complete</button>";
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



<script>
    function cancelOrder(orderId) {
        // Update remarks to "Order Cancelled"
        document.getElementById("remarks_" + orderId).innerText = "Order Cancelled";
        
        // Remove both buttons
        var cancelBtn = document.getElementById("cancelBtn_" + orderId);
        var completeBtn = document.getElementById("completeBtn_" + orderId);
        cancelBtn.parentNode.removeChild(cancelBtn);
        completeBtn.parentNode.removeChild(completeBtn);

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

    // Check if localStorage has remarks stored for each order
    // If yes, set the remarks accordingly
    window.onload = function() {
        var orderIds = document.querySelectorAll("[id^='remarks_']");
        orderIds.forEach(function(order) {
            var orderId = order.id.split("_")[1];
            var remarks = localStorage.getItem("remarks_" + orderId);
            if (remarks) {
                document.getElementById("remarks_" + orderId).innerText = remarks;
                
                // If remarks exist, remove the buttons
                var cancelBtn = document.getElementById("cancelBtn_" + orderId);
                var completeBtn = document.getElementById("completeBtn_" + orderId);
                if (cancelBtn && completeBtn) {
                    cancelBtn.parentNode.removeChild(cancelBtn);
                    completeBtn.parentNode.removeChild(completeBtn);
                }
            }
        });
    }
</script>
</body>
</html>
