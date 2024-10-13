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
    $time = date("Y-m-d H:i:s");

    // Combine tools and quantities into an array of objects
    $tools_data = [];
    foreach ($tools as $index => $tool) {
        // Make sure both tool and quantity are not empty
        if (!empty(trim($tool)) && isset($quantities[$index]) && !empty(trim($quantities[$index]))) {
            $quantity = (int)$quantities[$index]; // Make sure the quantity is an integer
            $tools_data[] = ['tool' => $tool, 'quantity' => $quantity];
        }
    }

    // Encode tools_data as JSON
    $tools_json = json_encode($tools_data);

    // Insert into task table
    $insert_task = "INSERT INTO task (tk_status,tk_data, rp_id, user_id, user, mainten_id, org_name, building_name, lift_id, tools) 
                    VALUES (1,?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_task = $conn->prepare($insert_task);
    if (!$stmt_task) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt_task->bind_param("siisissss", $task_detail, $report_id, $user_id, $user_rp, $engineer_id, $org_name, $building_name, $lift_name, $tools_json);

    if ($stmt_task->execute()) {
        $task_id = $stmt_task->insert_id; // Get the new task's ID

        // Insert into work table
        $insert_work = "INSERT INTO work (wk_status, tk_id, wk_detail) VALUES ('Assigned', ?, ?)";
        $stmt_work = $conn->prepare($insert_work);
        if (!$stmt_work) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt_work->bind_param("is", $task_id, $work_detail);

        // Insert into task_status table
        $insert_status = "INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, 'waiting', ?, 'มอบหมาย')";
        $stmt_status = $conn->prepare($insert_status);
        if (!$stmt_status) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt_status->bind_param("is", $task_id, $time);

        if ($stmt_work->execute() && $stmt_status->execute()) {
            // Delete the report
            $del_rp = "DELETE FROM report WHERE rp_id = ?";
            $stmt_rp = $conn->prepare($del_rp);
            if (!$stmt_rp) {
                die('Prepare failed: ' . $conn->error);
            }
            $stmt_rp->bind_param("i", $report_id);
            $stmt_rp->execute();

            echo "<script>
                alert('สร้างงานเสร็จสิ้น');
                window.location.href = 'report_list.php';
            </script>";
            exit();
        } else {
            echo "Error saving work or task status: " . $stmt_work->error . " / " . $stmt_status->error;
        }
        $stmt_work->close();
        $stmt_status->close();
    } else {
        echo "Error saving task: " . $stmt_task->error;
    }

    $stmt_task->close();
}
?>