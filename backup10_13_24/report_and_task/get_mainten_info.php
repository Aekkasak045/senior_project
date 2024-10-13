<?php
require("inc_db.php");

if (isset($_GET['mainten_id']) || isset($_GET['engineer_id'])) {
    // ใช้ mainten_id หรือ engineer_id ตามที่ได้รับจาก URL
    $id = isset($_GET['mainten_id']) ? $_GET['mainten_id'] : $_GET['engineer_id'];

    // SQL Query เพื่อดึงข้อมูลของช่าง
    $sql = "SELECT first_name, last_name, phone, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // แปลงข้อมูลเป็น JSON และส่งกลับ
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID not provided']);
}
?>
