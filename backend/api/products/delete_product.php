<?php
include('../../connection.php');


$product_id= $_POST['product_id'];

$query = $mysqli->prepare("delete from products where product_id=?");
$query->bind_param('i',$product_id);
$query->execute();

if ($mysqli->affected_rows>0){
    echo 'deleted successfully';
}else{
echo 'deleting failed';
}

$query->close();
$mysqli->close();