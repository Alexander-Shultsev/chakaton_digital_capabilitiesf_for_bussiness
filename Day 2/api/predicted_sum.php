<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

list($year, $month, $day) = explode("-", $date);

//$sql = "SELECT user_id, sum(sum) from grisha4c_db.`cheque` WHERE day(date) between 1 and 31 and month(date) = '$month' and year(date) = '$year' GROUP BY user_id";
$sql = "SELECT user_id, sum(s) from (SELECT user_id, sum(sum) as s, month(date) FROM `grisha4c_db`.`cheque` where user_id = $user_id group by month(date)) as tbl GROUP BY user_id";
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