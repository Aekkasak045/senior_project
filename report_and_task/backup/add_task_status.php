<?php
require("inc_db.php");

// Fetch all tk_id values from the task table for the dropdown
$sql = "SELECT tk_id FROM task";
$rs = mysqli_query($conn, $sql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tk_id = $_POST['tk_id'];
    $status = $_POST['status'];
    $detail = $_POST['detail'];
    $time = date("Y-m-d H:i:s"); // Auto-generate the current time

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $tk_id, $status, $time, $detail);

    if ($stmt->execute()) {
        $message = "New status added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the connection after the data fetching
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Add Task Status</title>
</head>
<body>
    <div class="container">
        <h2>Add Task Status</h2>

        <!-- Display message if available -->
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="tk_id" class="form-label">Select Task ID</label>
                <select class="form-select" id="tk_id" name="tk_id" required>
                    <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                        <option value="<?php echo htmlspecialchars($row['tk_id']); ?>">
                            <?php echo htmlspecialchars($row['tk_id']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <textarea class="form-control" id="detail" name="detail" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Status</button>
        </form>
    </div>
</body>
</html>
