<html>
    <head>
        <title>Edit Products - BSN</title>
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
            overflow: auto;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border 0.3s ease;
            animation: fade-in 1s forwards;
            resize: vertical;
            max-height: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            animation: fade-in 1s forwards;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            animation: fade-in 1s forwards;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border 0.3s ease;
            animation: fade-in 1s forwards;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #5E9FDF;
        } input[type="submit"] {
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
            $name = $_POST['name'];
            $price = $_POST['price'];
            $rating = $_POST['rating'];
            $description = $_POST['description'];

            $stmt = $db->prepare("UPDATE products SET name = ?, price = ?, rating = ?, description = ? WHERE id = ?");

            $stmt->bind_param("ssssi", $name, $price, $rating, $description, $id);

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
            <h1>Edit Products</h1>
            <form action="edit_product.php" method="post">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>">
                <label for="rating">Rating:</label>
                <input type="text" id="rating" name="rating" value="<?php echo $product['rating']; ?>">
                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo $product['description']; ?></textarea>
                <input type="submit" value="Update">
            </form>
        </div>
    </body>
</html>