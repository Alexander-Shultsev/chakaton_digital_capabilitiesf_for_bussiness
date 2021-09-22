<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

list($year, $month, $day) = explode("-", $date);

//$sql = "SELECT user_id, sum(sum) from grisha4c_db.`cheque` WHERE day(date) between 1 and 31 and month(date) = '$month' and year(date) = '$year' GROUP BY user_id";
$sql = "select `grisha4c_db`.`users`.`id`,`grisha4c_db`.`users`.`first_name`,`grisha4c_db`.`users`.`surname`,`grisha4c_db`.`users`.`lim`  from `grisha4c_db`.`users`";
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