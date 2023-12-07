<?php
include('../../connection.php');
require __DIR__.'../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

$headers=getallheaders();

if(!isset($headers['Authorization']) || empty($headers['Authorization']) ){
    http_response_code(401);
    echo json_encode(['error'=>'unauthorized']);
    exit();
}

$authorizationHeader = $headers['Authorization'];
$token=null;
$token = trim(str_replace("Bearer",'',$authorizationHeader));
if(!$token){
        http_response_code(401);
    echo json_encode(['error'=>'expired']);
    exit();
}


try {
    $key = 'secret_key';
    $decoded = JWT::decode($token,new Key($key,'HS256'));
    if($decoded->role_id==1){


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
}else{
    $response=[];
   $response["permissions"] =false;
    echo json_encode($response);
}
   

} catch (ExpiredException $e) {
      http_response_code(401);
      echo json_encode(['error'=>'unauthorized']);
}








?>
