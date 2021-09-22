<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

$date1 = $_GET['date1'];

$date2 = $_GET['date2'];

$sql = "SELECT sum(sum) as s
FROM `grisha4c_db`.`cheque`  
WHERE 
date >= DATE_ADD('$date1', INTERVAL -DAYOFWEEK(DATE_ADD('$date1' , INTERVAL -1 DAY)) DAY) and 
date <= DATE_ADD('$date2' , INTERVAL 7-DAYOFWEEK(DATE_ADD('$date2' , INTERVAL -1 DAY)) DAY) and
user_id = $user_id";

$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) != 0)
{
    http_response_code(200);    
    echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
}
else
{
    http_response_code(404);    
}
?>