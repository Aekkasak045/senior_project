<?php 
require ("inc_db.php");
include ("user_function.php");
$task_id=$_GET["tk_id"];


$sql = "SELECT task.tk_id,task.tk_status,task.tk_data,task.rp_id,task.user_id,task.user,task.mainten_id,task.org_name,task.building_name,task.lift_id,task.tools,
reporter.username AS reporter_username, reporter.first_name AS reporter_first_name, reporter.last_name AS reporter_last_name, reporter.email AS reporter_email, reporter.phone AS reporter_phone, reporter.role AS reporter_role,
mainten.username AS mainten_username, mainten.first_name AS mainten_first_name, mainten.last_name AS mainten_last_name, mainten.email AS mainten_email, mainten.phone AS mainten_phone, mainten.role AS mainten_role,
organizations.org_name,
building.building_name,
task_status.status,task_status.time,task_status.detail,
lifts.lift_name FROM task
INNER JOIN users AS reporter ON task.user_id = reporter.id
INNER JOIN users AS mainten ON task.mainten_id = mainten.id
INNER JOIN organizations ON task.org_name = organizations.org_name
INNER JOIN building ON task.building_name = building.building_name
INNER JOIN lifts ON task.lift_id = lifts.lift_name
INNER JOIN task_status ON task.tk_id = task_status.tk_id
WHERE task.tk_id=$task_id";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);


$timeline = "SELECT tk_status_id, status, time, detail 
        FROM task_status 
        WHERE tk_id = ? 
        ORDER BY tk_status_id DESC";
$stmt = $conn->prepare($timeline);
$stmt->bind_param("i", $task_id);  // ใช้ $task_id แทน $tk_id
$stmt->execute();
$result = $stmt->get_result();

$task_statuses = [];
if ($result->num_rows > 0) {
    while ($status_row = $result->fetch_assoc()) {  // ใช้ตัวแปรใหม่ $status_row เพื่อไม่ทับกับ $row ที่ใช้ด้านบน
        $task_statuses[] = $status_row;
    }
} else {
    echo "ไม่พบสถานะสำหรับงานนี้";
}

$stmt->close();
//$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูลหลังจากแสดงผลเสร็จสิ้น
?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="User.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Lift RMS</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="background1">
    <!-- navbar -->
    <?php require ('../navbar/navbar.php') ?>
    <div class="box-outer1">
        <div class="box-outer2">
            <div class="topinfo_task" style="display:flex; align-items: center;padding:5px;">
                <p class="User_information">TASK : <?php print ($row["tk_id"]); ?></p> 
                <p >STATUS:<?php echo show_task_status($row) ?></p>
                <a href="task_list.php" >Back</a>
            </div>
            <div class="sec1">
                <div class="row" style=" height:90%;">
                    <div class="col-sm-5"  style="margin-left: 50px;">
                        <div class="pro_bar">
                            process_bar
                        </div>
                        <div class="status_box" >

                            <ul class="timeline">
                                <?php foreach ($task_statuses as $status): ?>
                                    <li class="timeline-item">
                                        <div class="timeline-left">
                                            <span class="time"><?php echo date("d/m/y", strtotime($status['time'])); ?></span>
                                        </div>
                                        <div class="timeline-divider"></div>
                                        <div class="timeline-right">
                                            <span class="detail"><?php echo htmlspecialchars($status['detail']); ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>


                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="card" style="width: 80%;  margin: auto; ">
                            <div class="card-body">
                                <div class="container" >
                                <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">ข้อมูลช่างที่ปฏิบัติงาน</h5>
                                    Username: <?php print ($row["mainten_username"]); ?> <br>
                                    Name: <?php print ($row["mainten_first_name"]); ?> <?php print ($row["mainten_last_name"]); ?><br>
                                    Phone Number: <?php print ($row["mainten_phone"]); ?> <br>
                                    Email: <?php print ($row["mainten_email"]); ?> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 80%; margin: auto; margin-top: 1.5rem; ">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลผู้ใช้งานที่แจ้ง</h5>
                                Username: <?php print ($row["reporter_username"]); ?> <br>
                                Name: <?php print ($row["reporter_first_name"]); ?> <?php print ($row["reporter_last_name"]); ?><br>
                                Phone Number: <?php print ($row["reporter_phone"]); ?> <br>
                                Email: <?php print ($row["reporter_email"]); ?> <br>
                            </div>
                            </div>
                            <div class="card" style="width: 80%; margin: auto; margin-top: 1.5rem; ">
                                <div class="card-body">
                                    <h5 class="card-title">สถานที่</h5>
                                    Organizations: <?php print ($row["org_name"]); ?> <br>
                                    Building: <?php print ($row["building_name"]); ?> <br>
                                    Lift: <?php print ($row["lift_name"]); ?> <br>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>