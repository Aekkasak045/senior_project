<?php
require("inc_db.php"); // ไฟล์สำหรับเชื่อมต่อฐานข้อมูล

// การอัปโหลดรูปภาพ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
    $user_id = $_POST['user_id']; // ID ของผู้ใช้ที่รูปภาพจะถูกผูกไว้ด้วย

    // ตรวจสอบและจัดการรูปภาพที่อัปโหลด
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']); // อ่านข้อมูลของรูปภาพ

        // ใช้ prepared statements เพื่อป้องกัน SQL Injection
        $stmt = $conn->prepare("UPDATE users SET user_img = ? WHERE id = ?");
        $stmt->bind_param('bi', $imageData, $user_id);
        $stmt->send_long_data(0, $imageData); // ส่งข้อมูล BLOB ที่มีขนาดใหญ่

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Image Uploaded Successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to Upload Image!</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-warning">No Image Selected or Upload Error!</div>';
    }
}

// การดึงรูปภาพสำหรับการแสดงผล
$imageData = null;
if (isset($_GET['view_user_id'])) {
    $view_user_id = $_GET['view_user_id'];

    $stmt = $conn->prepare("SELECT user_img FROM users WHERE id = ?");
    $stmt->bind_param('i', $view_user_id);
    $stmt->execute();
    $stmt->bind_result($user_img);
    $stmt->fetch();

    if ($user_img) {
        $imageData = base64_encode($user_img); // แปลง BLOB เป็น Base64 เพื่อแสดงผล
    } else {
        echo '<div class="alert alert-info">No Image Found for User ID ' . htmlspecialchars($view_user_id) . '</div>';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and View User Image</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .custom-file-input:hover {
            cursor: pointer;
        }

        h2,
        h3 {
            margin-top: 20px;
            color: #343a40;
        }

        .img-preview {
            max-width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload User Image</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="user_id" class="form-label">User ID:</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="mb-4">
                <label for="image" class="form-label">Select Image:</label>
                <input type="file" class="form-control custom-file-input" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
        </form>

        <h2 class="text-center mt-5">View User Image</h2>
        <form action="" method="get" class="mb-4">
            <div class="mb-4">
                <label for="view_user_id" class="form-label">User ID to View:</label>
                <input type="number" class="form-control" id="view_user_id" name="view_user_id" required>
            </div>
            <button type="submit" class="btn btn-secondary w-100">View Image</button>
        </form>

        <?php if ($imageData): ?>
            <div class="text-center mt-5">
                <h3>Image for User ID: <?php echo htmlspecialchars($view_user_id); ?></h3>
                <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="User Image" class="img-preview mt-3">
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>