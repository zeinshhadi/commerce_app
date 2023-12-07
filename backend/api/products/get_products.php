<?php

include("../../connection.php");
$query=$mysqli->prepare('select * from products');
$query->execute();
$array=$query->get_result();
$response=[];

while($patient=$array->fetch_assoc()){
    $response[]=$patient;
}
echo json_encode($response);