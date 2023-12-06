<?php
include('../../connection.php');


$name =$_POST['product_name'];
$description = $_POST['description'];
$price= $_POST['price'];
$stock_quantity=$_POST['stock_quantity'];


$query = $mysqli->prepare('insert into products (name,description,price,stock_quantity) values(?,?,?,?)');
$query->bind_param('ssii',$name,$description,$price,$stock_quantity);
$query->execute();

$response["status"] = "true";
$response["name"] = $name;
$response["description"] = $description;
$response["price"] =$price;
$response["stock_quantity"] =$stock_quantity;


echo json_encode($response);