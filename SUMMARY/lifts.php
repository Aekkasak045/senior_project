<?php
$host = "localhost"; 
$username = "root"; 
$password = "kuse@fse2018"; 
$database = "smartlift"; 
$mysqli = new mysqli($host, $username, $password, $database,);

$sql = "SELECT lift_name  FROM lifts";
$result = $mysqli->query($sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    }

} 
else {
    echo "ไม่พบข้อมูล";
}

$conn->close();
?>