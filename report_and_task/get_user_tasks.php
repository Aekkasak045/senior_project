<?php
require("inc_db.php");

// รับค่า id จาก GET
$user_id = $_GET['id'];

// Query เพื่อดึงงานที่เกี่ยวข้องกับผู้ใช้
$sql = "SELECT tk_id, task_name FROM task WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// แสดงผลลัพธ์ในรูปแบบ HTML
if ($result->num_rows > 0) {
    echo '<ul class="list-group">';
    while ($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item">';
        // เพิ่มลิงก์ให้สามารถคลิกเพื่อไปยัง task_view.php พร้อมกับ tk_id
        echo '<a href="task_view.php?tk_id=' . $row['tk_id'] . '">';
        echo 'งาน: ' . htmlspecialchars($row['task_name']);
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo 'ไม่พบงานที่เกี่ยวข้อง';
}
$stmt->close();
$conn->close();
?>
