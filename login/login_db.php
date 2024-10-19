<?php
session_start();
$errors = array();
include('con_db.php');
include('errors.php');

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // ไม่ต้องทำการ escape รหัสผ่าน
    
    if (empty($username)) {
        array_push($errors, "กรุณาใส่ชื่อผู้ใช้");
    }
    if (empty($password)) {
        array_push($errors, "กรุณาใส่รหัสผ่าน");
    }

    if (count($errors) == 0) {
        // ใช้ prepared statements เพื่อความปลอดภัย
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            if ($row['role'] == 'admin') {
                $_SESSION['user_role'] = $row['role'];
                $_SESSION["username"] = $username;
                $_SESSION["success"] = "คุณเข้าสู่ระบบแล้ว";
                header('location: ../Manage1/summary/summary.php');
                exit();
            } else {
                array_push($errors, "คุณไม่มีสิทธิ์เข้าถึง");
                $_SESSION['error'] = "คุณไม่มีสิทธิ์เข้าถึง";
                header('location: login.php');
                exit();
            }
        } else {
            array_push($errors, "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
            $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            header('location: login.php');
            exit();
        }
    }
}
?>
