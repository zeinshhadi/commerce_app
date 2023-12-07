<?php 
 include('../../connection.php');
$username = $_POST['username'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role_id = $_POST['role_id'];
$query = $mysqli->prepare('insert into users (user_name, password, role_id) values(?,?,?)');
$query->bind_param('ssi',$username,$hashed_password,$role_id);

$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);