<?php

include("../../connection.php");
$username = $_POST['username'];
$password = $_POST['password'];

$query=$mysqli->prepare('select user_id,user_name,password from users where user_name=?');
$query->bind_param('s',$username);
$query->execute();
$query->store_result();
$num_rows=$query->num_rows;
$query->bind_result($id,$name,$hashed_password);
$query->fetch();


$response=[];
if($num_rows== 0){
    $response['status']= 'user not found';
    echo json_encode($response);
} else {

    if(password_verify($password,$hashed_password)){
        $response['status']= 'logged in';
        $response['user_id']=$id;
        $response['name']=$name;
        echo json_encode($response);
    } else {
        $response['status']= 'wrong credentials';
        echo json_encode($response);
    }
    
};