<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json;charset=utf-8');

$host = "localhost"; 
$username = "root"; 
$password = "kuse@fse2018"; 
$database = "smartlift"; 
$mysqli = new mysqli($host, $username, $password, $database,);

//FL1 VIEW
$sql = "SELECT COUNT(id) AS ELEVATOR FROM lifts";
$result = $mysqli->query($sql);
    $row1 = $result->fetch_assoc();

//FL2 VIEW
$sql = "SELECT COUNT(id) AS ELEVATOR FROM lifts";
$result = $mysqli->query($sql);
    $row2 = $result->fetch_assoc();

//FL3 VIEW
$sql = "SELECT COUNT(description) AS ELEVATOR FROM lifts";
$result = $mysqli->query($sql);
    $row3 = $result->fetch_assoc();

$response = array($row1,$row2,$row3);
echo json_encode($response);
$conn->close();

?>

