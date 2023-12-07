<?php
include("../../connection.php");

$customer_id = $_POST['customer_id'];
$get_orders_details = $mysqli->prepare("
    SELECT orders.order_id, orders.order_date, orderDetails.product_id, 
    orderDetails.quantity, orderDetails.price
    FROM orders
    INNER JOIN orderDetails ON orders.order_id = orderDetails.order_id
    WHERE orders.customer_id = ?
");
$get_orders_details->bind_param('i', $customer_id);
$get_orders_details->execute();

$result = $get_orders_details->get_result();
$response=[];
while ($orderDetails = $result->fetch_assoc()) {
    
    echo "Order ID: " . $orderDetails['order_id'];
    echo "Order Date: " . $orderDetails['order_date'];
    echo "Product ID: " . $orderDetails['product_id'];
    echo "Quantity: " . $orderDetails['quantity'];
    echo "Price: " . $orderDetails['price'];

}



$get_orders_details->close();

?>