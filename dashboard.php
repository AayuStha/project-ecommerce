<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        // Redirect to the login page if the user is not logged in
        header('Location: login.php');
        exit;
    }

    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .dashboard {
            text-align: center;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            padding: 50px;
            border-radius: 5px;
            background-color: #fff;
        }

        .dashboard h1 {
            font-size: 24px;
            color: #333;
        }

        .dashboard p {
            font-size: 18px;
            color: #666;
        }
    </style>

    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>This is your dashboard. You can add more content here.</p>
    </div>
</body>
</html>x    