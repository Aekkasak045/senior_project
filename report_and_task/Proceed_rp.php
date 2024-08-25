<?php
require ("inc_db.php");
$report_id=$_GET["rp_id"];

$engi="SELECT id,first_name,last_name FROM users WHERE role='mainten'";
$result=$conn->query($engi);
$engineers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $engineers[] = $row;
    }
} else {
    echo "No engineers found";
}

$sql = "SELECT report.rp_id,report.detail,report.date_rp,report.user_id
,users.username,users.first_name,users.last_name,users.email,users.phone,users.role,
organizations.org_name,
building.building_name,
lifts.lift_name FROM report 
INNER JOIN users ON report.user_id = users.id 
INNER JOIN organizations ON report.org_id = organizations.id
INNER JOIN building ON report.building_id = building.id
INNER JOIN lifts ON report.lift_id = lifts.id
WHERE report.rp_id=$report_id";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);

?>

<!-- ####################################################################### -->
<!-- เช็ค session ว่ามีหรือเปล่า -->
<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location:../login/login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:../login/login.php');
}
?>
<!-- ####################################################################### -->

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
            <section class="header_Table">
                <p class="User_information">Create Task: <?php print ($row["rp_id"]); ?></p> 
            </section>
            <div>
            </div>
            <div class="sec1">
                <div class="row" style=" height:90%;">
                    <div class="col-sm-6">
                    <form action="save_task.php" method="post">
                        <div class="card" style="width: 80%; margin-left: auto; ">
                            <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row["rp_id"]); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($row["username"]); ?>">
                            <input type="hidden" name="org_name" value="<?php echo htmlspecialchars($row["org_name"]); ?>">
                            <input type="hidden" name="building_name" value="<?php echo htmlspecialchars($row["building_name"]); ?>">
                            <input type="hidden" name="lift_name" value="<?php echo htmlspecialchars($row["lift_name"]); ?>">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลผู้ใช้งานที่แจ้ง</h5>
                                Username: <?php print ($row["username"]); ?> <br>
                                Name: <?php print ($row["first_name"]); ?> <?php print ($row["last_name"]); ?><br>
                                Phone Number: <?php print ($row["phone"]); ?> <br>
                                Email: <?php print ($row["email"]); ?> <br>
                            </div>
                        </div>
                        <div class="card" style="width: 80%; margin-left: auto; margin-top: 5rem; ">
                            <div class="card-body">
                                <h5 class="card-title">สถานที่</h5>
                                Organizations: <?php print ($row["org_name"]); ?> <br><br>
                                Building: <?php print ($row["building_name"]); ?> <br><br>
                                Lift: <?php print ($row["lift_name"]); ?> <br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card" style="width: 80%; height:100%; margin: auto; ">
                            <div class="card-body">
                                        <div class="container" >
                                            <div class="row">
                                                <div class="col-12">
                                                    Detail:
                                                        <input class="form-control" type="text" name="detail"  value="<?php echo htmlspecialchars($row["detail"]); ?>" style=" text-overflow: ellipsis; white-space: nowrap; ">
                                                    อุปกรณ์ที่ใช้:
                                                    <form action="" method="POST">
                                                    <div id="input-container">
                                                        <input type="text" name="tools[]" placeholder="ชื่ออุปกรณ์">
                                                    </div>
                                                    <button type="button" onclick="addInput()">เพิ่มอุปกรณ์</button>
                                                    <br><br>
                                                </div>
                                                    <label for="engineer">เลือกช่างที่จะรับงาน:</label>
                                                    <select name="engineer_id" id="engineer" required>
                                                        <?php foreach ($engineers as $engineer): ?>
                                                            <option value="<?= htmlspecialchars($engineer['id']) ?>"><?= htmlspecialchars($engineer['first_name']) ?><?php echo " " ?><?= htmlspecialchars($engineer['last_name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            <div class="col-12 d-flex justify-content-end">
                                            <input class="btn btn-primary" type="submit" name="edit" value="สร้างงาน">
                                            </div>
                                        </div>
                                    </form>
                                    <form action="delete_report.php" method="post" onsubmit="return confirm('คุณแน่ใจหรือว่าต้องการลบรายงานนี้?');">
                                    <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row['rp_id']); ?>">
                                        <button class="btn btn-danger" type="submit">ลบรายงาน</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
        function addInput() {
            const container = document.getElementById("input-container");
            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "tools[]"; // ตั้งค่า name เป็น array
            newInput.placeholder = "ชื่ออุปกรณ์";
            container.appendChild(newInput);
        }
</script>
