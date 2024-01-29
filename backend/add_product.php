<!-- add_product.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form action="insert_product.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label for="price">Price:</label><br>
            <input type="text" id="price" name="price" required><br>

            <label for="rating">Rating:</label><br>
            <select id="rating" name="rating" required>
                <option value="">Select a rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" required></textarea><br>

            <label for="image">Product Image:</label><br>
            <input type="file" id="image" name="image" required><br>

            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>