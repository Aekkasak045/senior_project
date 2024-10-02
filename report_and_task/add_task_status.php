<?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล

// Fetch all tk_id values from the task table for the dropdown
$sql = "SELECT tk_id FROM task";
$rs = mysqli_query($conn, $sql);

// Handle form submission
$message = ''; // Initialize message variable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tk_id = $_POST['tk_id'];
    $status = $_POST['status'];
    $detail = $_POST['detail'];
    $time = date("Y-m-d H:i:s"); // Auto-generate the current time

    // Check if an image is uploaded
    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] === UPLOAD_ERR_OK) {
        // Check file size (limit to 2.4MB)
        if ($_FILES['task_image']['size'] > 2400000) {
            $message = "Error: The image file is too large (max size: 2.4MB).";
        } else {
            // Read the image file contents into a BLOB
            $imageData = file_get_contents($_FILES['task_image']['tmp_name']);

            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail, tk_img) VALUES (?, ?, ?, ?, ?)");

            // ตรวจสอบการเตรียมคำสั่ง SQL
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind the parameters
            $null = NULL; // ใช้เพื่อระบุค่า null ในการเก็บ blob
            $stmt->bind_param("isssb", $tk_id, $status, $time, $detail, $null); // Bind the BLOB field as 'b'

            // ส่งข้อมูล binary data ด้วยการเรียกใช้ `send_long_data` หลังจาก `bind_param`
            $stmt->send_long_data(4, $imageData); // ส่งข้อมูล binary data

            if ($stmt->execute()) {
                $message = "New status with image added successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        // No image was uploaded, insert only text data
        $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("isss", $tk_id, $status, $time, $detail);

        if ($stmt->execute()) {
            $message = "New status added successfully without an image.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
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
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
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
            <div class="mb-3">
                <label for="task_image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="task_image" name="task_image" accept="image/*" onchange="validateImageSize()"> <!-- Accept image formats -->
            </div>
            <button type="submit" class="btn btn-primary">Add Status</button>
        </form>
    </div>

    <script>
        function validateImageSize() {
            const fileInput = document.getElementById('task_image');
            const file = fileInput.files[0];
            
            if (file.size > 2400000) {  // ขนาดไฟล์ 2.4MB = 2,400,000 bytes
                alert("The file is too large. Maximum size allowed is 2.4MB.");
                fileInput.value = '';  // รีเซ็ต input file ถ้าขนาดเกิน
            }
        }
    </script>
</body>
</html>
