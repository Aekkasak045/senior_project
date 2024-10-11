<?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล

// ดึง tk_id ทั้งหมดจากตาราง task
$sql_task_ids = "SELECT tk_id FROM task";
$result_task_ids = mysqli_query($conn, $sql_task_ids);

if ($result_task_ids->num_rows > 0) {
    // วนลูปผ่าน tk_id แต่ละอัน
    while ($row = $result_task_ids->fetch_assoc()) {
        $tk_id = $row['tk_id'];
        
        // ตรวจสอบค่า status ล่าสุดจากตาราง task_status โดยอ้างอิงจาก tk_id
        $sql_status = "SELECT status FROM task_status WHERE tk_id = ? ORDER BY tk_status_id DESC LIMIT 1";
        $stmt = $conn->prepare($sql_status);
        $stmt->bind_param("i", $tk_id);
        $stmt->execute();
        $result_status = $stmt->get_result();

        if ($result_status->num_rows > 0) {
            $status_row = $result_status->fetch_assoc();
            $status = $status_row['status'];
            if ($status == "preparing") {
                $new_status = 2;
                $new_work_status = 2 ;
            }elseif ($status == "working") {
                $new_status = 3;
                $new_work_status = 3 ;
            } elseif ($status == "working") {
                $new_status = 4;
                $new_work_status = 4 ;
            } elseif ($status == "finish") {
                $new_status == 5;
                $new_work_status = 6 ;
            } else {
                continue; 
            }

            $update_task = "UPDATE task SET tk_status = ? WHERE tk_id = ?";
            $stmt_update = $conn->prepare($update_task);
            $stmt_update->bind_param("ii", $new_status, $tk_id);
            $stmt_update->execute();
            $stmt_update->close();

            $update_work = "UPDATE work SET wk_status = ? WHERE tk_id = ?";
            $stmt_update_work = $conn->prepare($update_work);
            $stmt_update_work->bind_param("ii", $new_work_status, $tk_id);
            $stmt_update_work->execute();
            $stmt_update_work->close();
        }

        $stmt->close();
    }
}

// $conn->close();
?>