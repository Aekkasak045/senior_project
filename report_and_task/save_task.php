<?php
require("inc_db.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $report_id = $_POST['rp_id'];
    $user_id = $_POST['user_id'];
    $user_rp = $_POST['username'];
    $org_name = $_POST['org_name'];
    $building_name = $_POST['building_name'];
    $lift_name = $_POST['lift_name'];
    $task_detail = $_POST['detail'];
    $engineer_id = $_POST['engineer_id'];
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    $work_detail = $_POST['detail'];
    $work_image = "path_to_image"; // Placeholder for image path
    $time = date("Y-m-d H:i:s"); 

    // Combine tools and quantities into an array of objects
    $tools_data = [];
    foreach ($tools as $index => $tool) {
        $quantity = isset($quantities[$index]) ? $quantities[$index] : 1;
        $tools_data[] = ['tool' => $tool, 'quantity' => $quantity];
    }

    // แปลงข้อมูล tools เป็น JSON
    $tools_json = json_encode($tools_data);

    // บันทึกข้อมูลลงในตาราง task
    $insert_task = "INSERT INTO task (tk_data, rp_id, user_id, user, mainten_id, org_name, building_name, lift_id, tools) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_task = $conn->prepare($insert_task);
    $stmt_task->bind_param("siisissss", $task_detail, $report_id, $user_id, $user_rp, $engineer_id, $org_name, $building_name, $lift_name, $tools_json);

    if ($stmt_task->execute()) {
        $task_id = $stmt_task->insert_id; // รับค่า tk_id ของงานที่ถูกสร้างใหม่

        // บันทึกข้อมูลลงในตาราง work
        $insert_work = "INSERT INTO work (wk_status, tk_id, wk_detail, wk_img) VALUES ('Assigned', ?, ?, ?)";
        $stmt_work = $conn->prepare($insert_work);
        $stmt_work->bind_param("iss", $task_id, $work_detail, $work_image);

        // บันทึกข้อมูลลงในตาราง task_status
        $insert_status = "INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, 'waiting', ?, 'รอดำเนินการ')";
        $stmt_status = $conn->prepare($insert_status);
        $stmt_status->bind_param("is", $task_id, $time);

        if ($stmt_work->execute() && $stmt_status->execute()) {
            // ลบ report
            $del_rp = "DELETE FROM report WHERE rp_id = ?";
            $stmt_rp = $conn->prepare($del_rp);
            $stmt_rp->bind_param("i", $report_id);
            $stmt_rp->execute();

            echo "<script>
                alert('สร้างงานเสร็จสิ้น');
                window.location.href = 'report_list.php';
            </script>";
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลในตาราง work หรือ task_status: " . $stmt_work->error . " / " . $stmt_status->error;
        }
        $stmt_work->close();
        $stmt_status->close();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลในตาราง task: " . $stmt_task->error;
    }

    $stmt_task->close();
}
?>

?>
