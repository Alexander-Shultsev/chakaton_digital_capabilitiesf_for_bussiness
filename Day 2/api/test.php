<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

$file = $_GET['file'];

$sum = $_GET['sum'];

$date = $_GET['date'];

$time = $_GET['time'];


$sql = "INSERT INTO grisha4c_db.cheque ( `user_id`, `file`, `sum`, `date`, `time`) VALUES ( $user_id, '$file', $sum, '$date', '$time');";

echo $sql;

$result = mysqli_query($link, $sql) or die( mysqli_error($link) );

echo "sdhsdghsdh";


echo $result;

echo $link;

?>