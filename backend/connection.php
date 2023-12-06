<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,POST,DELETE');
header('Access-Control-Allow-Headers:*');


$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "commerce";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("" . $mysqli->connect_error);
} else {

}
