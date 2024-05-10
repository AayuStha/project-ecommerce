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
            padding: 3px;
            margin: 15px 0;
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
    session_start();
    $quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity'] : 0;
    include '../config.php';
    $mysqli = new mysqli($servername, $username, $password, $database);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $query = "SELECT id FROM products";
    $stm = $mysqli->prepare($query);
    $stm->execute();

    // Get the result of the query
    $result = $stm->get_result();

    // Fetch all product_ids and store them in an array
    $product_id = array();
    while ($row = $result->fetch_assoc()) {
        $product_ids[] = $row['id'];
    }

    $stmt = $mysqli->prepare("SELECT * FROM orders");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Order ID</th><th>Product Id</th><th>User ID</th><th>Total Price</th><th>Date</th><th>Quantity</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["product_id"] . "</td><td>" . $row["user_id"] . "</td><td>" . $row["price"] . "</td><td>" . $row["order_date"] . "</td><td>" . $row["quantity"] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No orders found.";
    }

    $mysqli->close();
?>
</body>
</html>