<?php
    session_start();

    // Hardcoded username and password
    $correct_username = 'admin';
    $correct_password = 'aayu';

    if(isset($_POST['username'], $_POST['password'])) {
        // Trim the username and password
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Check if the entered username and password match the hardcoded values
        if ($username === $correct_username && $password === $correct_password) {
            // Store user data in the session
            $_SESSION['username'] = $username;

            // Redirect to admin panel
            header('Location: admin_panel.php');
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
?>
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
    <style>.error{color: #af0505;}</style>
    
</head>
<body>
    <div class="login-box">
        <h1>BagShopNepal</h1>
        <h2>Admin Login</h2>
        
        <form action="admin_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit">Login</button>
        </form>
        <?php
            if(isset($error)) {
                echo '<div class="error">' . $error . '</div>';
            }
        ?>
    </div>
</body>
</html>