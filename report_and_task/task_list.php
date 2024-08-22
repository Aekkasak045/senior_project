<?php
require ("inc_db.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูล task ทั้งหมดจากฐานข้อมูล
$sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id, users.first_name AS engineer_first_name, users.last_name AS engineer_last_name, task.org_name, task.building_name, task.lift_id, task.tools
        FROM task
        INNER JOIN users ON task.user_id = users.id
        ORDER BY task.tk_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Task List</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Task Detail</th>
                    <th>Engineer</th>
                    <th>Organization</th>
                    <th>Building</th>
                    <th>Lift</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tk_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['tk_status']); ?></td>
                            <td><?php echo htmlspecialchars($row['tk_data']); ?></td>
                            <td><?php echo htmlspecialchars($row['engineer_first_name'] . ' ' . $row['engineer_last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['org_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['building_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['lift_id']); ?></td>
                            <td><?php echo htmlspecialchars(implode(", ", json_decode($row['tools'], true))); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No tasks found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
