<?php
    session_start(); // Start the session if it's not already started

    // Check if the admin is not logged in
    if (!isset($_SESSION['username'])) {
        // Redirect to the login page
        header('Location: ./admin_login.php');
        exit();
    }

?>
<html>
    <head>
        <title>Delete Products - BSN</title>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border: 5px solid #5E9FDF;
            border-radius: 8px;
            box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.1);
            width: 300px;
            animation: slide-in 0.5s forwards;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            animation: fade-in 1s forwards;
        }

        p {
            margin-bottom: 20px;
            animation: fade-in 1s forwards;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #5E9FDF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin-top: 20px;
            width: 100%;
            animation: fade-in 1s forwards;
        }

        input[type="submit"]:hover {
            background-color: #4C8FD4;
        }
        @keyframes slide-in {
            0% {
                transform: translateX(-50px);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
    </head>
    <body>
        <?php
        include '../config.php';

        $db = new mysqli($servername, $username, $password, $database);

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id = $_POST['id'];

            $stmt = $db->prepare("DELETE FROM products WHERE id = ?");

            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header('Location: admin_panel.php');
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            $id = $_GET['id'];

            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
        }
        ?>
        <div class="container">
            <h1>Delete the product?</h1>
            <form action="delete_product.php" method="post">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <p>Are you sure you want to delete the following product?</p>
                <p>Name: <?php echo $product['name']; ?></p>
                <p>Price: <?php echo $product['price']; ?></p>
                <input type="submit" value="Delete">
            </form>
        </div>
    </body>
</html>