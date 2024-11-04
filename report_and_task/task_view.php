<?php
require("inc_db.php");
include("user_function.php");
include("update_task_status.php");

// รับค่า tk_id จาก URL
$task_id = $_GET["tk_id"];

// SQL Query เพื่อดึงข้อมูลทั้งหมด
$sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id, task.user_id, task.user, task.mainten_id, task.org_name, task.building_name, task.lift_id, task.tools,task_start_date,
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
    <link rel="stylesheet" href="task_view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Lift RMS</title>


</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php'); ?>
    <div class="box-outer1">
        <div class="box-outer2">
            <div class="topinfo_task">
                <h5 class="topic">TASK : <?php echo $row["tk_id"]; ?></h5>
                <p>STATUS: <?php echo show_task_status($row); ?></p>
                <a href="task_list.php" class="back">Back</a>
            </div>
            <div class="sec1">
                <div class="row">
                    <!-- Progress Bar -->
                    <div class="col-sm-6">
                        <div class="pro_bar">
                            <div class="progress-container">
                                <div class="step">
                                    <div class="circle" id="step1">&#10003;</div>
                                    <div class="step-label" id="label1">assign</div>
                                </div>
                                <div class="line" id="line1"></div>
                                <div class="step">
                                    <div class="circle" id="step2">&#10003;</div>
                                    <div class="step-label" id="label2">preparing</div>
                                </div>
                                <div class="line" id="line2"></div>
                                <div class="step">
                                    <div class="circle" id="step3">&#10003;</div>
                                    <div class="step-label" id="label3">prepared</div>
                                </div>
                                <div class="line" id="line3"></div>
                                <div class="step">
                                    <div class="circle" id="step4">&#10003;</div>
                                    <div class="step-label" id="label4">working</div>
                                </div>
                                <div class="line" id="line4"></div>
                                <div class="step">
                                    <div class="circle" id="step5">&#10003;</div>
                                    <div class="step-label" id="label5">complete</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">รายละเอียดงาน</h5>
                                        วันที่และเวลาเริ่มงาน: <?php echo date("d/m/Y H:i", strtotime($row["task_start_date"])); ?>
                                        <br>รายละเอียดงาน:<?php echo $row["tk_data"]; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Timeline -->
                        <div class="status_box">
                            <ul class="timeline">
                                <?php
                                // จัดกลุ่มสถานะโดยใช้ array เพื่อเก็บสถานะต่างๆ
                                $status_groups = [
                                    'finish' => 'เสร็จสิ้น',
                                    'working' => 'กำลังปฏิบัติ',
                                    'prepared' => 'เตรียมอุปกรณ์เสร็จสิน',
                                    'preparing' => 'กำลังเตรียมอุปกรณ์',
                                    'assign' => 'มอบหมาย',
                                ];
                                // วนลูปแสดงกลุ่มสถานะ
                                foreach ($status_groups as $status_key => $status_label) {
                                    // หาสถานะที่ตรงกับ key ของกลุ่มนี้
                                    $has_items = false; // เช็คว่ามีรายการในกลุ่มหรือไม่
                                    foreach ($task_statuses as $status) {
                                        if ($status['status'] == $status_key) {
                                            if (!$has_items) {
                                                // แสดงหัวข้อหลักของกลุ่มเมื่อเจอรายการที่ตรงกับสถานะกลุ่มนี้
                                                echo '<h4 class="status-group">' . $status_label . '</h4>';
                                                $has_items = true;
                                            }
                                ?>
                                            <li class="timeline-item">
                                                <div class="timeline-left">
                                                    <span class="time"><?php echo date("d/m/y H:i", strtotime($status['time'])); ?></span>
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
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- ข้อมูลช่างและผู้ใช้งาน -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลช่างที่ปฏิบัติงาน</h5>
                                <div class="img">
                                    <?php if (!empty($row["mainten_user_img"])): ?>
                                        <div class="text-center mb-3">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row["mainten_user_img"]); ?>" alt="Engineer Image" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                    <div class="img_text">
                                        Username: <?php echo $row["mainten_username"]; ?> <br>
                                        Name: <?php echo $row["mainten_first_name"] . " " . $row["mainten_last_name"]; ?><br>
                                        Phone Number: <?php echo $row["mainten_phone"]; ?> <br>
                                        Email: <?php echo $row["mainten_email"]; ?> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลผู้ใช้งานที่แจ้ง</h5>
                                <div class="img">
                                    <?php if (!empty($row["reporter_user_img"])): ?>
                                        <div class="text-center mb-3">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row["reporter_user_img"]); ?>" alt="Reporter Image" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                    <div class="img_text">
                                        Username: <?php echo $row["reporter_username"]; ?> <br>
                                        Name: <?php echo $row["reporter_first_name"] . " " . $row["reporter_last_name"]; ?><br>
                                        Phone Number: <?php echo $row["reporter_phone"]; ?> <br>
                                        Email: <?php echo $row["reporter_email"]; ?> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">สถานที่</h5>
                                <div class="img">
                                    <div class="img_location">
                                        <img src="img/building.png" class="img-fluid" style="width:60px; height: 60px; border-radius: 50%; margin: 0 15px 0 15px;" alt="location-icon">
                                    </div>
                                    <div class="img_text">
                                        Organizations: <?php echo $row["org_name"]; ?> <br>
                                        Building: <?php echo $row["building_name"]; ?> <br>
                                        Lift: <?php echo $row["lift_name"]; ?> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">เครื่องมือที่ใช้</h5>
                                <!-- เพิ่ม div ที่ห่อหุ้มส่วนที่จะแสดงเครื่องมือ -->
                                <div class="tools-container sec1" style="max-height: 200px; overflow-y: auto;">
                                    <ul class="text_tools">
                                        <?php
                                        $tools = json_decode($row['tools'], true);
                                        $total_cost = 0; // ตัวแปรสำหรับเก็บมูลค่ารวม
                                        if (is_array($tools)) {
                                            foreach ($tools as $tool) {
                                                if (isset($tool['tool']) && isset($tool['quantity'])) {
                                                    // ดึงข้อมูล cost จากตาราง tools
                                                    $tool_name = $tool['tool'];
                                                    $quantity = $tool['quantity'];
                                                    $sql_tool_cost = "SELECT cost FROM tools WHERE tool_name = ?";
                                                    $stmt_tool_cost = $conn->prepare($sql_tool_cost);
                                                    $stmt_tool_cost->bind_param("s", $tool_name);
                                                    $stmt_tool_cost->execute();
                                                    $result_tool_cost = $stmt_tool_cost->get_result();
                                                    $tool_cost = $result_tool_cost->fetch_assoc()['cost'];
                                                    // คำนวณมูลค่าของเครื่องมือแต่ละชิ้น
                                                    $item_total_cost = $tool_cost * $quantity;
                                                    $total_cost += $item_total_cost;
                                                    // แสดงผลเครื่องมือพร้อมจำนวนและ cost โดยแยกบรรทัดใหม่
                                                    echo '<li class="tools">'
                                                        . htmlspecialchars($tool['tool']) . '<br>'
                                                        . 'จำนวน: ' . htmlspecialchars($tool['quantity']) . '<br>'
                                                        . 'ราคา: ' . htmlspecialchars($tool_cost) . ' บาท<br>'
                                                        . 'มูลค่ารวม: ' . $item_total_cost . ' บาท'
                                                        . '</li><br>';
                                                }
                                            }
                                            // แสดงผลมูลค่ารวมของเครื่องมือทั้งหมด
                                            echo '<p>มูลค่ารวมของเครื่องมือทั้งหมด: ' . $total_cost . ' บาท</p>';
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
    </div>
</body>

<script>
    let tk_status = <?php echo $row['tk_status']; ?>;

    // Update progress bar based on the status
    for (let i = 1; i <= 6; i++) {
        if (i < tk_status || tk_status == 5) {
            // กรณีที่ tk_status มากกว่าขั้นตอนที่ i (สีเขียว - สำเร็จแล้ว)
            document.getElementById('step' + i).classList.add('active');
            document.getElementById('label' + i).classList.remove('inactive');
            if (i < tk_status && tk_status == 5) {
                document.getElementById('line' + i).classList.add('active');
            }
        } else if (i == tk_status && tk_status <= 5) {
            document.getElementById('step' + i).classList.add('onstep');
            document.getElementById('label' + i).classList.remove('inactive');
        } else {
            // กรณีที่ tk_status ยังไม่ถึงขั้นตอนนั้น
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