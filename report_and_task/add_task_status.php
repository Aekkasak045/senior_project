<!-- <?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล


$sql = "SELECT tk_id FROM task";
$rs = mysqli_query($conn, $sql);


$message = ''; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tk_id = $_POST['tk_id'];
    $status = $_POST['status'];
    $detail = $_POST['detail'];
    $time = date("Y-m-d H:i:s"); 

    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] === UPLOAD_ERR_OK) {

        if ($_FILES['task_image']['size'] > 2400000) {
            $message = "Error: The image file is too large (max size: 2.4MB).";
        } else {

            $imageData = file_get_contents($_FILES['task_image']['tmp_name']);


            $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail, tk_img) VALUES (?, ?, ?, ?, ?)");

    
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

          
            $null = NULL; 
            $stmt->bind_param("isssb", $tk_id, $status, $time, $detail, $null); 

            
            $stmt->send_long_data(4, $imageData); 

            if ($stmt->execute()) {
                $message = "New status with image added successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
     
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

        
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data"> 
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
                <input type="file" class="form-control" id="task_image" name="task_image" accept="image/*" onchange="validateImageSize()"> 
            </div>
            <button type="submit" class="btn btn-primary">Add Status</button>
        </form>
    </div>

    <script>
        function validateImageSize() {
            const fileInput = document.getElementById('task_image');
            const file = fileInput.files[0];
            
            if (file.size > 2400000) {  
                alert("The file is too large. Maximum size allowed is 2.4MB.");
                fileInput.value = '';  
        }
    </script>
</body>
</html>
 -->

 <?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล

// ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tk_id = $_POST['tk_id'];
    $status = $_POST['status'];
    $detail = $_POST['detail'];
    $time = date("Y-m-d H:i:s"); // กำหนดเวลาเป็นเวลาปัจจุบัน

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบขนาดไฟล์ (จำกัดขนาดไฟล์ที่ 2.4MB)
        if ($_FILES['task_image']['size'] > 2400000) {
            $message = "Error: ขนาดไฟล์ภาพใหญ่เกินไป (ขนาดสูงสุด: 2.4MB).";
        } else {
            // อ่านข้อมูลไฟล์ภาพและแปลงเป็น BLOB
            $imageData = file_get_contents($_FILES['task_image']['tmp_name']);

            // เตรียม SQL สำหรับเพิ่มข้อมูล
            $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail, tk_img) VALUES (?, ?, ?, ?, ?)");

            // ตรวจสอบว่าการเตรียมคำสั่ง SQL สำเร็จหรือไม่
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind ค่าต่าง ๆ เข้ากับ SQL
            $stmt->bind_param("isssb", $tk_id, $status, $time, $detail, $null); // ใช้ BLOB สำหรับภาพ
            $stmt->send_long_data(4, $imageData); // ส่งข้อมูลภาพ

            // ตรวจสอบการบันทึก
            if ($stmt->execute()) {
                $message = "สถานะใหม่ถูกเพิ่มสำเร็จพร้อมกับรูปภาพ.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        // ไม่มีการอัปโหลดภาพ ให้เพิ่มเฉพาะข้อมูลสถานะ
        $stmt = $conn->prepare("INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("isss", $tk_id, $status, $time, $detail);

        if ($stmt->execute()) {
            $message = "สถานะใหม่ถูกเพิ่มสำเร็จโดยไม่มีรูปภาพ.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
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
    <div class="container mt-5">
        <h2>เพิ่มสถานะของงาน (Add Task Status)</h2>

        <!-- Display message if available -->
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
            <div class="mb-3">
                <label for="tk_id" class="form-label">เลือก Task ID</label>
                <select class="form-select" id="tk_id" name="tk_id" required>
                    <?php
                    // ดึงค่า task id จากฐานข้อมูลเพื่อแสดงใน select
                    $sql = "SELECT tk_id FROM task";
                    $rs = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($rs)) {
                        echo '<option value="' . htmlspecialchars($row['tk_id']) . '">' . htmlspecialchars($row['tk_id']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="waiting">รอดำเนินการ</option>
                    <option value="working">กำลังดำเนินการ</option>
                    <option value="finish">เสร็จสิ้น</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="detail" class="form-label">รายละเอียด</label>
                <textarea class="form-control" id="detail" name="detail" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="task_image" class="form-label">อัปโหลดรูปภาพ (ถ้ามี)</label>
                <input type="file" class="form-control" id="task_image" name="task_image" accept="image/*" onchange="validateImageSize()">
            </div>

            <button type="submit" class="btn btn-primary">เพิ่มสถานะ</button>
        </form>
    </div>

    <script>
        function validateImageSize() {
            const fileInput = document.getElementById('task_image');
            const file = fileInput.files[0];
            
            if (file.size > 2400000) {  // ขนาดไฟล์ 2.4MB = 2,400,000 bytes
                alert("ขนาดไฟล์ภาพใหญ่เกินไป (สูงสุด 2.4MB).");
                fileInput.value = '';  // รีเซ็ต input file ถ้าขนาดเกิน
            }
        }
    </script>
</body>
</html>
