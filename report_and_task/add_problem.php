<?php
require 'inc_db.php';

if (isset($_POST['new_problem'])) {
    $new_problem = mysqli_real_escape_string($conn, $_POST['new_problem']);

    // ตรวจสอบว่าปัญหามีอยู่แล้วหรือไม่
    $check_problem = "SELECT * FROM problem WHERE pb_name = '$new_problem'";
    $result_check = mysqli_query($conn, $check_problem);

    if (mysqli_num_rows($result_check) == 0) {
        // เพิ่มรายการปัญหาใหม่
        $sql_add_problem = "INSERT INTO problem (pb_name) VALUES ('$new_problem')";
        if (mysqli_query($conn, $sql_add_problem)) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "exists"; // หากปัญหามีอยู่แล้ว
    }
}
?>
