<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === true) {
    // User is logged in, proceed to display the shipping details form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Details</title>
</head>
<body>
    <h2>Please enter your shipping details</h2>
    <form action="thanks.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="number">Contact:</label>
        <input type="number" id="number" name="number">
        <label for="city">City/District:</label>
        <input type="text" id="city" name="city">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
        <label for="landmark">Landmark:</label>
        <input type="text" id="landmark" name="landmark">
        <br> <br>
        <h2>Please select your payment method</h2>
        <input type="radio" id="cod" name="payment" value="cod">
        <label for="cod">Cash on Delivery</label><br>
        <input type="radio" id="esewa" name="payment" value="esewa">
        <label for="esewa">Esewa</label><br>
        <input type="submit" value="Place order">
    </form>
</body>
</html>

<?php
} else {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit;
}
?>
