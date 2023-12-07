<?php 
 include('../../connection.php');
$username = $_POST['username'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli->prepare('insert into users (user_name, password, role_id) values(?,?,2)');
$query->bind_param('ss',$username,$hashed_password);

$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);