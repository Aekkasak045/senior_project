<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=utf-8");
include './/conn_db.php';
try {
   
  $users = array();
  foreach($conn->query("SELECT * from user ") as $row){
    array_push($users,array
    (
        'id' => $row['id'],
        'fname' => $row['fname'],
        'lname' => $row['lname'],
        'email'=> $row['email'],
        'address' => $row['address']
    ));
        
    } 
    echo json_encode($users);
    $conn = null;
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>