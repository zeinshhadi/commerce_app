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
    if($decoded->role_id==1 && $decoded->user_id){
        $seller_id = $decoded->user_id;
        $response=[];
        $name =$_POST['product_name'];
        $description = $_POST['description'];
        $price= $_POST['price'];
        $stock_quantity=$_POST['stock_quantity'];

    
    $query = $mysqli->prepare('insert into products (name,description,price,stock_quantity,seller_id) values(?,?,?,?,?)');
    $query->bind_param('ssiii',$name,$description,$price,$stock_quantity,$seller_id);
    $query->execute();

    $response["status"] = "true";
    $response["name"] = $name;
    $response["description"] = $description;
    $response["price"] =$price;
    $response["stock_quantity"] =$stock_quantity;
    $response["seller_id"] =$seller_id;
    $response["permissions"] =true;
}else{
    $response=[];
   $response["permissions"] =false;
}
    echo json_encode($response);

} catch (ExpiredException $e) {
      http_response_code(401);
      echo json_encode(['error'=>'unauthorized']);
}

