<?php
include './/conn_db.php';

try {
   
    $stmt = $conn->prepare("SELECT * FROM user where id = ?");
    $stmt->execute([$_GET['id']]);
    foreach ($stmt as $row) {
      $user = array(
        'id' => $row['id'],
        'fname' => $row['fname'],
        'lname' => $row['lname'],
        'email'=> $row['email'],
        'address' => $row['address']
      );
      echo json_encode($user);
      break;
    }
    
      $conn = null;
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>