<?php
require("inc_db.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    
    $sql = "SELECT tk_id, tk_data, tk_status FROM task WHERE mainten_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
        // ถ้าอยากเปลี่นfontขนาดหรือสีให้มาเปลี่่ยนตรงนี้ Newwww
    if ($result->num_rows > 0) {
        echo '<ul class="list-group">';
        while ($task = $result->fetch_assoc()) {
            echo '<li class="list-group-item" href="../report_and_task/task_view.php?tk_id=' . htmlspecialchars($task['tk_id']) . '">';

            echo '<div onclick="window.location=\'../report_and_task/task_view.php?tk_id=' . htmlspecialchars($task['tk_id']) . '\'" class="task-link">';

            echo 'TaskID: '.htmlspecialchars($task['tk_id']). '<br>';
            echo 'Task: ' . htmlspecialchars($task['tk_data']). '<br>' ;
            echo 'Status: ';
            switch ($task['tk_status']) {
                case 1:
                    echo 'มอบหมาย';
                    break;
                case 2:
                    echo 'กำลังเตรียมอุปกรณ์';
                    break;
                case 3:
                    echo 'เตรียมอุปกรณ์เสร็จสิ้น';
                    break;
                case 4:
                    echo 'กำลังดำเนินการ';
                    break;
                case 5:
                    echo 'ดำเนินการเสร็จสิ้น';
                    break;
                default:
                    echo 'สถานะไม่ทราบ';
            }
            // echo 'TaskID: '.htmlspecialchars($task['tk_id']).'Task: ' . htmlspecialchars($task['tk_data']) . ' Status: ' . htmlspecialchars($task['tk_status']);
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No tasks found for this user.';
    }

    $stmt->close();
}
?>