<?php
include('../../connection.php');

$customer_id = $_POST['customer_id'];
$product_id = $_POST['product_id'];
$order_date = date("Y-m-d H:i:s");
$quantity = $_POST['quantity'];

$insert_query = $mysqli->prepare("INSERT INTO orders (customer_id, order_date) VALUES (?, ?)");
$insert_query->bind_param('is', $customer_id, $order_date);
$insert_query->execute();

$order_id = $mysqli->insert_id;

$insert_query->close();

$get_price = $mysqli->prepare("SELECT price FROM products WHERE product_id = ?");
$get_price->bind_param('i', $product_id);
$get_price->execute();
$get_price->bind_result($price);
$get_price->fetch();
$get_price->close();

$insert_order_details = $mysqli->prepare("INSERT INTO OrderDetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
$insert_order_details->bind_param('iiid', $order_id, $product_id, $quantity, $price);
$insert_order_details->execute();
$insert_order_details->close();


?>
