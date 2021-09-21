<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$link = mysqli_connect("localhost", "grisha4c_db", "P@ssw0rd");

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM grisha4c_db.cheque where user_id = $user_id";

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