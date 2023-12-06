<?php
include('../../connection.php');

$product_id = $_POST['product_id'];

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock_quantity = $_POST['stock_quantity'];


$query = $mysqli->prepare('UPDATE products SET name=?, description=?, price=?, stock_quantity=? WHERE product_id=?');
$query->bind_param('ssdii', $name, $description, $price, $stock_quantity, $product_id);
$query->execute();

if ($mysqli->affected_rows > 0) {
    echo 'Product updated successfully';
} else {
    echo 'No rows updated';
}


$query->close();
$mysqli->close();
?>
