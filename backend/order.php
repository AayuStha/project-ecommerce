<?php
// Include your database connection file
include '../config.php';
$mysqli = new mysqli($servername, $username, $password, $database);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
// Prepare and execute the statement
$stmt = $mysqli->prepare("SELECT * FROM orders");
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any orders
if ($result->num_rows > 0) {
    echo "<table border=1 cellspacing=10 cellpadding=10>";
    echo "<tr><th>Order ID</th><th>Product ID</th><th>User ID</th><th>Total Price</th><th>Date</th></tr>";

    // Output data of each order
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["id"] . "</td><td>" . $row["user_id"] . "</td><td>" . $row["price"] . "</td><td>" . $row["order_date"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "No orders found.";
}

$mysqli->close();
?>