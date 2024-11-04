<?php
require("inc_db.php");

$year = isset($_GET['year']) ? $_GET['year'] : null; // ปีที่ต้องการกรอง
$lift_id = isset($_GET['lift_id']) ? $_GET['lift_id'] : null; // ลิฟต์ที่ต้องการกรอง

// เริ่มต้นคำสั่ง SQL
$sql = "SELECT tk_data AS problem, COUNT(tk_id) AS occurrences FROM task";

// กำหนดเงื่อนไขการกรอง ถ้ามีปีหรือลิฟต์ที่เลือก
if ($year || $lift_id) {
    $conditions = [];
    if ($year) {
        $conditions[] = "YEAR(task_start_date) = ?";
    }
    if ($lift_id) {
        $conditions[] = "lift_id = ?";
    }
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " GROUP BY tk_data";

// เตรียม statement
$stmt = $conn->prepare($sql);

// ผูกตัวแปรตามการกรอง
if ($year && $lift_id) {
    $stmt->bind_param("is", $year, $lift_id);
} elseif ($year) {
    $stmt->bind_param("i", $year);
} elseif ($lift_id) {
    $stmt->bind_param("s", $lift_id);
}

$stmt->execute();
$result = $stmt->get_result();

$problems = [];
while ($row = $result->fetch_assoc()) {
    $problems[] = [
        'problem' => $row['problem'],
        'occurrences' => $row['occurrences']
    ];
}

header('Content-Type: application/json');
echo json_encode($problems);
?>
