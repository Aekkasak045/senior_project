<?php
require("inc_db.php");

// ดึงปีทั้งหมดจากฐานข้อมูล
$yearSql = "SELECT DISTINCT YEAR(task_start_date) AS year FROM task ORDER BY year DESC";
$yearResult = mysqli_query($conn, $yearSql);
$years = [];
while ($row = mysqli_fetch_assoc($yearResult)) {
    $years[] = $row['year'];
}

// ดึงลิฟต์ทั้งหมดจากฐานข้อมูล (ใช้ lift_id เป็นชื่อของลิฟต์)
$liftSql = "SELECT DISTINCT lift_id FROM task ORDER BY lift_id";
$liftResult = mysqli_query($conn, $liftSql);
$lifts = [];
while ($row = mysqli_fetch_assoc($liftResult)) {
    $lifts[] = $row['lift_id']; // lift_id แทนด้วยชื่อของลิฟต์
}

// ส่งข้อมูลเป็น JSON
echo json_encode([
    'years' => $years,
    'lifts' => $lifts
]);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
