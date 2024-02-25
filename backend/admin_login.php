<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title>BSN - Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    
</head>
<body>
    <div class="login-box">
        <h1>BagShopNepal</h1>
        <h2>Admin Login</h2>
        <?php
        // Connect to the database
        ob_start();
        include '../config.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $db = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        if(isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password']);

            // Prepare the SQL query
            $sql = "SELECT password FROM admins WHERE username = ?";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the parameters
            $stmt->bind_param('s', $username);

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    header('Location: admin_panel.php');
                    exit;
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }

            $stmt->close();
        }

        $db->close();
        ?>
        <form action="admin_panel.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>