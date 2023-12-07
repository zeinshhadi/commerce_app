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
        $seller_id =  $decoded->user_id;

$product_id= $_POST['product_id'];

$query = $mysqli->prepare("delete from products where product_id=? and seller_id=?");
$query->bind_param('ii',$product_id,$seller_id);
$query->execute();

if ($mysqli->affected_rows>0){
    echo 'deleted successfully';
}else{
echo 'deleting failed';
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




