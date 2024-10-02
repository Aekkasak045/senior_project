<?php
require("inc_db.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query to get tasks assigned to the user
    $sql = "SELECT tk_id, tk_data, tk_status FROM task WHERE mainten_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<ul class="list-group">';
        while ($task = $result->fetch_assoc()) {
            echo '<li class="list-group-item">';
            echo '<a style="color:black;" href="../report_and_task/task_view.php?tk_id=' . htmlspecialchars($task['tk_id']) . '" class="task-link">';
            echo 'TaskID: '.htmlspecialchars($task['tk_id']).'<br>Task: ' . htmlspecialchars($task['tk_data']) . ' <br>Status: ' . htmlspecialchars($task['tk_status']);
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No tasks found for this user.';
    }

    $stmt->close();
}
?>
