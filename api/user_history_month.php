<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

$date = $_GET['date'];

list($year, $month, $day) = explode("-", $date);

$sql = "SELECT 
	sum(`grisha4c_db`.`cheque`.`sum`) as s, 
    (`grisha4c_db`.`users`.`lim` - 
    sum(`grisha4c_db`.`cheque`.`sum`)) as l
FROM 
	`grisha4c_db`.`cheque` inner join `grisha4c_db`.`users` 
    on `grisha4c_db`.`cheque`.`user_id` = 
    `grisha4c_db`.`users`.`id` 
WHERE 
	month(`grisha4c_db`.`cheque`.`date`) = $month and 
    year(`grisha4c_db`.`cheque`.`date`) = $year and 
    `grisha4c_db`.`cheque`.`user_id` = $user_id";

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