<?php
require("inc_db.php");
include("user_function.php");

// รับค่า tk_id จาก URL
$task_id = $_GET["tk_id"];

// SQL Query เพื่อดึงข้อมูลทั้งหมด
$sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id, task.user_id, task.user, task.mainten_id, task.org_name, task.building_name, task.lift_id, task.tools,
        reporter.username AS reporter_username, reporter.first_name AS reporter_first_name, reporter.last_name AS reporter_last_name, reporter.email AS reporter_email, reporter.phone AS reporter_phone, reporter.role AS reporter_role, reporter.user_img AS reporter_user_img,
        mainten.username AS mainten_username, mainten.first_name AS mainten_first_name, mainten.last_name AS mainten_last_name, mainten.email AS mainten_email, mainten.phone AS mainten_phone, mainten.role AS mainten_role, mainten.user_img AS mainten_user_img,
        organizations.org_name,
        building.building_name,
        task_status.status, task_status.time, task_status.detail,
        lifts.lift_name 
        FROM task
        INNER JOIN users AS reporter ON task.user_id = reporter.id
        INNER JOIN users AS mainten ON task.mainten_id = mainten.id
        INNER JOIN organizations ON task.org_name = organizations.org_name
        INNER JOIN building ON task.building_name = building.building_name
        INNER JOIN lifts ON task.lift_id = lifts.lift_name
        INNER JOIN task_status ON task.tk_id = task_status.tk_id
        WHERE task.tk_id = $task_id";

$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);

// SQL Query สำหรับไทม์ไลน์
$timeline = "SELECT tk_status_id, status, time, detail 
             FROM task_status 
             WHERE tk_id = ? 
             ORDER BY tk_status_id DESC";

$stmt = $conn->prepare($timeline);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();

$task_statuses = [];
if ($result->num_rows > 0) {
    while ($status_row = $result->fetch_assoc()) {
        $task_statuses[] = $status_row;
    }
} else {
    echo "ไม่พบสถานะสำหรับงานนี้";
}
$stmt->close();

// SQL Query สำหรับดึงข้อมูลรูปภาพจากตาราง task_status โดยดึง tk_status_id มาด้วย
$work_sql = "SELECT tk_status_id, tk_img FROM task_status WHERE tk_id = ?";
$stmt_work = $conn->prepare($work_sql);
$stmt_work->bind_param("i", $task_id);
$stmt_work->execute();
$result_work = $stmt_work->get_result();
$work_images = [];

if ($result_work->num_rows > 0) {
    while ($work_row = $result_work->fetch_assoc()) {
        // จับคู่รูปภาพกับ tk_status_id
        if (!empty($work_row['tk_img'])) {
            $work_images[$work_row['tk_status_id']] = base64_encode($work_row['tk_img']); // แปลงรูปภาพเป็น Base64
        }
    }
}
$stmt_work->close();




?>
 
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="User.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Lift RMS</title>
</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php'); ?>
    <div class="box-outer1">
        <div class="box-outer2">
            <div class="topinfo_task" style="display: flex; align-items: center; padding: 5px;">
                <p class="User_information">TASK : <?php echo $row["tk_id"]; ?></p>
                <p>STATUS: <?php echo show_task_status($row); ?></p>
                <a href="task_list.php">Back</a>
            </div>
            <div class="sec1">
                <div class="row" style="height: 90%;">
                    <!-- Progress Bar -->
                    <div class="col-sm-5" style="margin-left: 50px;">
                        <div class="pro_bar">
                            <div class="progress-container">
                                <div class="step">
                                    <div class="circle" id="step1">1</div>
                                    <div class="step-label" id="label1">Step 1</div>
                                </div>
                                <div class="line" id="line1"></div>
                                <div class="step">
                                    <div class="circle" id="step2">2</div>
                                    <div class="step-label" id="label2">Step 2</div>
                                </div>
                                <div class="line" id="line2"></div>
                                <div class="step">
                                    <div class="circle" id="step3">3</div>
                                    <div class="step-label" id="label3">Step 3</div>
                                </div>
                                <div class="line" id="line3"></div>
                                <div class="step">
                                    <div class="circle" id="step4">4</div>
                                    <div class="step-label" id="label4">Step 4</div>
                                </div>
                            </div>
                        </div>

                        <div >
                            <div class="col-sm-12">
                                <div class="card" style="width: 100%; margin: auto;">
                                    <div class="card-body">
                                        <h5 class="card-title">รายละเอียดงาน</h5>
                                        <?php echo $row["tk_data"]; ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Timeline -->
                        <div class="status_box">
                            <ul class="timeline">
                                <?php foreach ($task_statuses as $index => $status): ?>
                                    <li class="timeline-item">
                                        <div class="timeline-left">
                                            <span class="time"><?php echo date("d/m/y", strtotime($status['time'])); ?></span>
                                        </div>
                                        <div class="timeline-divider"></div>
                                        <div class="timeline-right">
                                            <span class="detail"><?php echo htmlspecialchars($status['detail']); ?></span>

                                        <!-- เช็คว่ามีรูปภาพใน work หรือไม่ -->
                                        <?php if (!empty($work_images[$status['tk_status_id']])): ?>
                                            <br>
                                            <a href="#" class="view-image" data-image="data:image/jpeg;base64,<?php echo $work_images[$status['tk_status_id']]; ?>">ดูรูปภาพ</a>
                                        <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach ; ?>
                            </ul>
                        </div>

                    </div>

                    <!-- ข้อมูลช่างและผู้ใช้งาน -->
                    <div class="col-sm-6">
                        <div class="card" style="width: 80%; margin: auto;">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลช่างที่ปฏิบัติงาน</h5>
                                <?php if (!empty($row["mainten_user_img"])): ?>
                                    <div class="text-center mb-3">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row["mainten_user_img"]); ?>" alt="Engineer Image" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                <?php endif; ?>
                                Username: <?php echo $row["mainten_username"]; ?> <br>
                                Name: <?php echo $row["mainten_first_name"] . " " . $row["mainten_last_name"]; ?><br>
                                Phone Number: <?php echo $row["mainten_phone"]; ?> <br>
                                Email: <?php echo $row["mainten_email"]; ?> <br>
                            </div>
                        </div>

                        <div class="card" style="width: 80%; margin: auto; margin-top: 1.5rem;">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลผู้ใช้งานที่แจ้ง</h5>
                                <?php if (!empty($row["reporter_user_img"])): ?>
                                    <div class="text-center mb-3">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row["reporter_user_img"]); ?>" alt="Reporter Image" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                <?php endif; ?>
                                Username: <?php echo $row["reporter_username"]; ?> <br>
                                Name: <?php echo $row["reporter_first_name"] . " " . $row["reporter_last_name"]; ?><br>
                                Phone Number: <?php echo $row["reporter_phone"]; ?> <br>
                                Email: <?php echo $row["reporter_email"]; ?> <br>
                            </div>
                        </div>

                        <div class="card" style="width: 80%; margin: auto; margin-top: 1.5rem;">
                            <div class="card-body">
                                <h5 class="card-title">สถานที่</h5>
                                Organizations: <?php echo $row["org_name"]; ?> <br>
                                Building: <?php echo $row["building_name"]; ?> <br>
                                Lift: <?php echo $row["lift_name"]; ?> <br>
                            </div>
                        </div>

                        <div class="card" style="width: 80%; margin: auto; margin-top: 1.5rem;">
                            <div class="card-body">
                                <h5 class="card-title">เครื่องมือที่ใช้</h5>
                                <ul>
                                    <?php
                                    $tools = json_decode($row['tools'], true);
                                    if (is_array($tools)) {
                                        foreach ($tools as $tool) {
                                            if (isset($tool['tool']) && isset($tool['quantity'])) {
                                                echo '<li>' . htmlspecialchars($tool['tool']) . ' (จำนวน: ' . htmlspecialchars($tool['quantity']) . ')</li>';
                                            }
                                        }
                                    } else {
                                        echo '<li>ไม่มีเครื่องมือ</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    // Get the actual status from the PHP variable
    let tk_status = <?php echo $row['tk_status']; ?>;

    // Update progress bar based on the status
    for (let i = 1; i <= 4; i++) {
        if (i <= tk_status) {
            document.getElementById('step' + i).classList.add('active');
            document.getElementById('label' + i).classList.remove('inactive');
            if (i < tk_status) {
                document.getElementById('line' + i).classList.add('active');
            }
        } else {
            document.getElementById('label' + i).classList.add('inactive');
        }
    }
</script>
<!-- Pop-up container -->
<div id="imageModal" class="modal" style="display:none;">
    <span class="close">&times;</span>
    <img class="modal-content" id="popupImage">
</div>

<script>
    // ฟังก์ชันสำหรับเปิดป๊อปอัพแสดงรูปภาพ
document.querySelectorAll('.view-image').forEach(item => {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        var imgSrc = this.getAttribute('data-image');
        document.getElementById('popupImage').src = imgSrc; // ใช้ Base64 image string
        document.getElementById('imageModal').style.display = 'block';
    });
});

// ฟังก์ชันสำหรับปิดป๊อปอัพ
document.querySelector('.close').onclick = function() {
    document.getElementById('imageModal').style.display = 'none';
}

</script>

</html>