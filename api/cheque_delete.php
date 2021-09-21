<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$id = $_GET['id'];

$sql = "DELETE FROM grisha4c_db.`cheque` WHERE grisha4c_db.`cheque`.`id` = $id";

$result = mysqli_query($link, $sql);

?>