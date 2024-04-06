<!-- add_product.php -->
<!DOCTYPE html>
<html lang="en">
<head>
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

        label {
            display: block;
            margin-top: 20px;
            animation: fade-in 1s forwards;
        }

        input[type="text"], select, textarea {
            width: 94%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border 0.3s ease;
            animation: fade-in 1s forwards;
        }

        input[type="text"]:focus, select:focus, textarea:focus {
            border-color: #5E9FDF;
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
    <div class="container">
        <h1>Add Product</h1>
        <form action="insert_product.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label for="price">Price:</label><br>
            <input type="text" id="price" name="price" required><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" required></textarea><br>

            <label for="image">Product Image:</label><br>
            <input type="file" id="image" name="image" required><br>

            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>