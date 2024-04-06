<?php
session_start();

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == true){
    if(isset($_POST['product'])){
        $product = $_POST['product'];
    }
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" action="checkout.php">
    Name: <input type="text" name="name"><br>
    Email: <input type="text" name="email"><br>
    Phone: <input type="text" name="phone"><br>
    Product: <input type="text" name="product" value="<?php echo $product; ?>"><br>
    <input type="submit" value="Checkout">
</form>

</body>
</html>

<?php
} else {
    echo "You must be logged in to add items to the cart.";
}
?>