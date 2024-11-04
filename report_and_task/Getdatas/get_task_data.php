<?php
require("inc_db.php");

// รับค่าปีและลิฟต์จาก AJAX
$year = isset($_GET['year']) && !empty($_GET['year']) ? $_GET['year'] : null;
$lift_id = isset($_GET['lift_id']) && !empty($_GET['lift_id']) ? $_GET['lift_id'] : null;

// ตรวจสอบว่าเลือกปีหรือไม่ ถ้าไม่เลือกให้ใช้ปีล่าสุด
if ($year === null) {
    $latestYearSql = "SELECT MAX(YEAR(task_start_date)) AS latest_year FROM task";
    $result = mysqli_query($conn, $latestYearSql);
    $row = mysqli_fetch_assoc($result);
    $year = $row['latest_year']; // ใช้ปีล่าสุด
}

// สร้าง SQL เพื่อกรองตามปีและลิฟต์
$sql = "SELECT tk_data, COUNT(tk_id) AS task_count 
        FROM task 
        WHERE YEAR(task_start_date) = '$year'";

// ถ้ามีการเลือก lift_id ให้กรองเพิ่มเติม
if ($lift_id !== null && $lift_id !== '') {
    $sql .= " AND lift_id = '$lift_id'";
}

$sql .= " GROUP BY tk_data";

$result = mysqli_query($conn, $sql);

$problems = [];
$problem_counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $problems[] = $row['tk_data'];
    $problem_counts[] = $row['task_count'];
}

// ส่งข้อมูลเป็น JSON
header('Content-Type: application/json');
echo json_encode([
    'problems' => $problems,
    'problem_counts' => $problem_counts
]);
?>