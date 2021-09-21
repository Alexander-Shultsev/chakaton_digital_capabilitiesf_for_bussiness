<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$id = $_GET['id'];

$sum = $_GET['sum'];

$date = $_GET['date'];

$time = $_GET['time'];

$sql = "UPDATE grisha4c_db.`cheque` SET `sum` = $sum, `date` = '$date', `time` = '$time' WHERE grisha4c_db.`cheque`.`id` = $id";

$result = mysqli_query($link, $sql);


?>