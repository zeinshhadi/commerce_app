<?php

include("../../connection.php");
require __DIR__.'../../../vendor/autoload.php';
use Firebase\JWT\JWT;

$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
$username = $_POST['username'];
$password = $_POST['password'];

$query=$mysqli->prepare('select user_id,user_name,password,role_id from users where user_name=?');
$query->bind_param('s',$username);
$query->execute();
$query->store_result();
$num_rows=$query->num_rows;
$query->bind_result($id,$name,$hashed_password,$role_id);
$query->fetch();


$response=[];
if($num_rows== 0){
    $response['status']= 'user not found';
    echo json_encode($response);
} else {

    if(password_verify($password,$hashed_password)){
        $key='secret_key';
        $payload_array=[];
        $payload_array['role_id']=$role_id;
        $payload_array['user_id']=$id;
        $payload_array['user_name']=$name;
        $payload=$payload_array;
        $response['status']= 'success';
        $jwt=JWT::encode($payload,$key,'HS256');
        $response['jwt']=$jwt;
        $response['user_id']=$id;
        echo json_encode($response);
    } else {
        $response['status']= 'wrong credentials';
        echo json_encode($response);
    }
    
};