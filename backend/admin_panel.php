<?php
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
        font-size: 2.5em;
        color: #333;
        text-align: center;
        padding-bottom: 10px;
        border-bottom: 2px solid #333;
        margin-bottom: 20px;
    }

    p {
        text-align:center;
        font-size: 1.2em;
        line-height: 1.6em;
        color: #666;
        margin-bottom: 20px;
    }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        text-decoration: none;
        }
        tr:nth-child(even) {
        background-color: #f2f2f2;
        }
        #add{
            margin: 10px;
            background-color: #5e34eb;
        }
        #log{
            margin: 10px;
            background-color: #000;
        }
        .table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    display: table;
}

table td, table th {
    word-break: break-word;
}
.product-table td {
    word-wrap: break-word;      /* Allow long words to be able to break and wrap onto the next line */
    max-width: 300px;           /* Any max-width you want */
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Panel</h1>
        <p>Here you can manage your e-commerce site.</p>
        <button class="btn" id="add" onclick="location.href='add_product.php'">Add Product</button>
        <div class="table-responsive">
        <table class="product-table">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Rating</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
                // Connect to the database
    include '../config.php';
    $db = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
                // Fetch products from the database
                $sql = "SELECT * FROM products";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    // Output each product
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["rating"] . "/5</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td><img src='uploads/" . $row["image"] . "' width='100' '></td>";
                        echo "<td>";
                        echo "<button class='btn' onclick=\"location.href='edit_product.php?id=" . $row["id"] . "'\">Edit</button>";
                        echo "<button class='btn' onclick=\"location.href='delete_product.php?id=" . $row["id"] . "'\">Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
            ?>
        </table>
            </div>
        <button class="btn" id="log" onclick="location.href='logout.php'" >Logout</button>
    </div>
</body>
</html>