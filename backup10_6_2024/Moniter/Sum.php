<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json;charset=utf-8');

$host = "localhost"; // Database host address
$username = "root"; // Database username
$password = "kuse@fse2018"; // Database password
$database = "smartlift"; // Database name

$response = array();
$response_count = $response;
$count = count($response_count);

for ($i = 0; $i < $count; $i++) {
    $response[$count] = $data1;
    $response[$count] = $data2;
    $response[$count] = $data3;
}

$mysqli = new mysqli($host, $username, $password, $database,);

//Organization
$sql = "SELECT COUNT(id) AS ORGANIZATIONS FROM organizations";
$result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) 
        $data1 = $row;
        
//Building
$sql = "SELECT COUNT(id) AS BUILDING FROM lifts";
$result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) 
        $data2 = $row;

//ELEVATOR
$sql = "SELECT description, COUNT(description) AS description FROM organizations";
$result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) 
        $data3 = $row;

echo json_encode($response);
$conn->close();
?>

