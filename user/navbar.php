<?php
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $query = "SELECT firstname FROM users WHERE id = {$_SESSION['user_id']}";
        $result = mysqli_query($connection, $query);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $firstName = $row['firstname'];
                echo "<li class='dropdown'>";
                echo "<a href='#' class='dropbtn'>Howdy, $firstName <i class='fa fa-caret-down'></i></a>";
                echo "<div class='dropdown-content'>";
                echo "<a href='../user/change_password.php'>Change Password</a>";
                echo "<a href='../user/logout.php'>Logout</a>";
                echo "</div></li>";
            } else {
                echo '<li><a href="/project-ecommerce/login.php">Login</a></li>';
                echo '<li><a href="/project-ecommerce/signup.html">Signup</a></li>';
            }
        } else {
            echo "ERROR: Could not execute $query. " . mysqli_error($connection);
        }
    } else {
        echo '<li><a href="/project-ecommerce/login.php">Login</a></li>';
        echo '<li><a href="/project-ecommerce/signup.html">Signup</a></li>';
    }
?>