<?php
require('inc_db.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $date_rp = date('Y-m-d H:i:s'); // Set the current date and time automatically
    $user_id = $_POST['user_id'];
    $org_id = $_POST['org_id'];
    $building_id = $_POST['building_id'];
    $lift_id = $_POST['lift_id'];
    $detail = $_POST['detail'];

    // เตรียม SQL statement เพื่อเพิ่มข้อมูลในฐานข้อมูล
    $sql = "INSERT INTO report (date_rp, user_id, org_id, building_id, lift_id, detail) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // ผูกค่าตัวแปรกับ SQL statement
        $stmt->bind_param("siiiis", $date_rp, $user_id, $org_id, $building_id, $lift_id, $detail);
        
        // ตรวจสอบว่าการดำเนินการสำเร็จหรือไม่
        if ($stmt->execute()) {
            echo "Report created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // ปิด statement
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close(); // ปิดการเชื่อมต่อกับฐานข้อมูล
}
?>
