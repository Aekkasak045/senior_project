<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=utf-8");
include './/conn_db.php';

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
    echo json_encode(array("status" =>"error"));
    die();
}

try {
    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bindParam(1, $data->id);


    if ($stmt->execute()){
        echo json_encode(array('status' => "ok"));
    }else{
        echo json_encode(array('status' => "error"));
    }
    $conn = null;
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>