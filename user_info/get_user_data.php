<?php
require("inc_db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // แปลงรูปภาพ BLOB เป็น Base64
    if ($user['user_img']) {
        $user['user_img'] = base64_encode($user['user_img']);
    }

    echo json_encode($user);
    $stmt->close();
}
