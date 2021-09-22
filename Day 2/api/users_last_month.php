<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

$date = $_GET['date'];

list($year, $month, $day) = explode("-", $date);

//$sql = "SELECT user_id, sum(sum) from grisha4c_db.`cheque` WHERE day(date) between 1 and 31 and month(date) = '$month' and year(date) = '$year' GROUP BY user_id";
$sql = "SELECT avg(`grisha4c_db`.`cheque`.`sum`) as avg_sum , sum(`grisha4c_db`.`cheque`.`sum`) as sum_sum , 
(select avg(`grisha4c_db`.`cheque`.`sum`) from `grisha4c_db`.`cheque` where DATE_ADD(`grisha4c_db`.`cheque`.`date`,INTERVAL  1 MONTH) = '$date') as avg_sum_day
from `grisha4c_db`.`cheque` 
WHERE month(DATE_ADD(`grisha4c_db`.`cheque`.`date`,INTERVAL  1 MONTH)) = '$month' 
and year(DATE_ADD(`grisha4c_db`.`cheque`.`date`,INTERVAL  1 MONTH)) = '$year'";
if ($user_id) {
    $sql = $sql." and `grisha4c_db`.`cheque`.`user_id` = $user_id";
}

#echo $sql;
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