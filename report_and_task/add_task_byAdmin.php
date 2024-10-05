<!-- ระบบฐานข้อมูล -->
<?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล

// ฟังก์ชันดึง Report ID ล่าสุด
$sql_latest_report = "SELECT rp_id FROM task ORDER BY rp_id DESC LIMIT 1";
$result_latest_report = $conn->query($sql_latest_report);
$latest_report = $result_latest_report->fetch_assoc()['rp_id'];

// ดึงข้อมูล Organization
$sql_org = "SELECT id as org_id, org_name FROM organizations";
$org_result = $conn->query($sql_org);

// ดึงข้อมูลผู้ใช้
$sql_users = "SELECT id,username, first_name, last_name FROM users";
$users_result = $conn->query($sql_users);

// ดึงข้อมูลช่าง
$sql_mainten = "SELECT id, first_name, last_name FROM users WHERE role = 'mainten'";
$mainten_result = $conn->query($sql_mainten);

// ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rp_id = $_POST['rp_id'];
    $user_id = $_POST['user_id'];
    $username=$_POST['username'];
    $org_id = $_POST['org_id']; // ดึง org_id
    $org_name = $_POST['org_name']; // ดึง org_name จาก hidden field
    $building_name = $_POST['building_name'];
    $lift_name = $_POST['lift_name'];
    $task_detail = $_POST['detail'];
    $mainten_id = $_POST['mainten_id'];
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    $time = date("Y-m-d H:i:s");

    // จัดการ tools และ quantities เป็น JSON
    $tools_data = [];
    foreach ($tools as $index => $tool) {
        if (!empty(trim($tool)) && !empty(trim($quantities[$index]))) {
            $tools_data[] = ['tool' => $tool, 'quantity' => (int)$quantities[$index]];
        }
    }
    $tools_json = json_encode($tools_data);

    $sql = "INSERT INTO task (tk_data, rp_id, user_id, user, mainten_id, org_name, building_name, lift_id, tools, tk_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siisissss", $task_detail, $rp_id, $user_id, $username, $mainten_id, $org_name, $building_name, $lift_name, $tools_json);

if ($stmt->execute()) {
    // ดึง task_id ของงานที่เพิ่งถูกสร้างขึ้น
    $task_id = $stmt->insert_id; 

    // Insert ข้อมูลลงในตาราง work
    $insert_work = "INSERT INTO work (wk_status, tk_id, wk_detail) VALUES ('Assigned', ?, ?)";
    $stmt_work = $conn->prepare($insert_work);
    if (!$stmt_work) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt_work->bind_param("is", $task_id, $task_detail);
    
    // Insert ข้อมูลลงในตาราง task_status
    $insert_status = "INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, 'waiting', ?, 'มอบหมาย')";
    $stmt_status = $conn->prepare($insert_status);
    if (!$stmt_status) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt_status->bind_param("is", $task_id, $time);

    if ($stmt_work->execute() && $stmt_status->execute()) {
        echo "<script>alert('สร้างงานเสร็จสิ้น!'); window.location.href = 'task_list.php';</script>";
    } else {
        echo "Error saving work or task status: " . $stmt_work->error . " / " . $stmt_status->error;
    }

    // ปิดการเชื่อมต่อ statement
    $stmt_work->close();
    $stmt_status->close();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
    
}


// การดึงข้อมูล Building และ Lift จะถูกจัดการผ่าน AJAX
if (isset($_GET['org_id'])) {
    $org_id = $_GET['org_id'];

    // ดึง Building ที่ตรงกับ Organization
    $sql_building = "SELECT id as building_id, building_name FROM building WHERE org_id = ?";
    $stmt_building = $conn->prepare($sql_building);
    $stmt_building->bind_param("i", $org_id);
    $stmt_building->execute();
    $result_building = $stmt_building->get_result();

    $buildings = [];
    while ($row = $result_building->fetch_assoc()) {
        $buildings[] = $row;
    }

    // ดึง Lift ที่ตรงกับ Organization
    $sql_lift = "SELECT id as lift_id, lift_name FROM lifts WHERE org_id = ?";
    $stmt_lift = $conn->prepare($sql_lift);
    $stmt_lift->bind_param("i", $org_id);
    $stmt_lift->execute();
    $result_lift = $stmt_lift->get_result();

    $lifts = [];
    while ($row = $result_lift->fetch_assoc()) {
        $lifts[] = $row;
    }

    echo json_encode(['buildings' => $buildings, 'lifts' => $lifts]);
    exit();
}
?>

<!-- ------------------------------------------------------------------- -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Create Task</title>
</head>
<body>

    <div class="container mt-5">
    <?php require('../navbar/navbar.php'); ?>

    <h2>สร้างงาน (Create Task)</h2>
        <form action="" method="POST">
            <!-- Report ID (Auto fill เป็นค่าล่าสุด) -->
            <div class="mb-3">
                <label for="rp_id" class="form-label">Report ID</label>
                <input type="text" class="form-control" id="rp_id" name="rp_id" value="<?php echo $latest_report+1; ?>" >
            </div>

            <!-- เลือกผู้ใช้ -->
            <div class="mb-3">
        <label for="user_id" class="form-label">เลือกผู้ใช้</label>
        <select class="form-select" id="user_id" name="user_id" onchange="fetchUserData(this.value)" required>
            <option value="">เลือกผู้ใช้</option>
            <?php while ($user = $users_result->fetch_assoc()) { ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['id'] . " - " . $user['first_name'] . " " . $user['last_name']; ?></option>
            <?php } ?>
        </select>
    </div>

    <!-- Hidden field สำหรับเก็บ username -->
    <input type="hidden" id="username" name="username" value="">

    <!-- แสดงข้อมูลผู้ใช้ -->
    <div id="user_info" class="mb-3">
        <h5>ข้อมูลผู้แจ้ง:</h5>
        <p id="user_name"></p>
        <p id="user_username"></p>
        <p id="user_phone"></p>
    </div>


            <!-- เลือก Organization -->
            <div class="mb-3">
                <label for="org_id" class="form-label">Organization</label>
                <select class="form-select" id="org_id" name="org_id" onchange="fetchOrgData(this.value)" required>
                    <option value="">เลือก Organization</option>
                    <?php while ($org = $org_result->fetch_assoc()) { ?>
                        <option value="<?php echo $org['org_id']; ?>"><?php echo $org['org_id'] . " - " . $org['org_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" id="org_name" name="org_name" value="">

            <!-- เลือก Building (ขึ้นอยู่กับ Organization) -->
            <div class="mb-3">
                <label for="building_name" class="form-label">Building</label>
                <select class="form-select" id="building_name" name="building_name" required>
                    <option value="">เลือก Building</option>
                </select>
            </div>

            <!-- เลือก Lift (ขึ้นอยู่กับ Organization) -->
            <div class="mb-3">
                <label for="lift_name" class="form-label">Lift</label>
                <select class="form-select" id="lift_name" name="lift_name" required>
                    <option value="">เลือก Lift</option>
                </select>
            </div>

            <!-- รายละเอียดงาน -->
            <div class="mb-3">
                <label for="detail" class="form-label">รายละเอียดงาน</label>
                <textarea class="form-control" id="detail" name="detail" rows="3" required></textarea>
            </div>

            <!-- เลือกช่าง -->
            <div class="mb-3">
                <label for="mainten_id" class="form-label">เลือกช่าง</label>
                <select class="form-select" id="mainten_id" name="mainten_id" onchange="fetchMaintenData(this.value)" required>
                    <option value="">เลือกช่าง</option>
                    <?php while ($mainten = $mainten_result->fetch_assoc()) { ?>
                        <option value="<?php echo $mainten['id']; ?>"><?php echo $mainten['id'] . " - " . $mainten['first_name'] . " " . $mainten['last_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- แสดงข้อมูลช่าง -->
            <div id="mainten_info" class="mb-3">
                <h5>ข้อมูลช่าง:</h5>
                <p id="mainten_name"></p>
                <p id="mainten_username"></p>
                <p id="mainten_phone"></p>
            </div>

            <!-- เครื่องมือที่ใช้ -->
            <div class="mb-3">
                <label for="tools" class="form-label">เครื่องมือที่ใช้</label>
                <div id="tools-container">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="tools[]" placeholder="ชื่อเครื่องมือ">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="quantities[]" placeholder="จำนวน">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary" onclick="addTool()">เพิ่มเครื่องมือ</button>
            </div>

            <button type="submit" class="btn btn-primary">สร้างงาน</button>
        </form>
    </div>

    <!-- ฟังก์ชั้นการเรียกตัวแปร -->
    <script>
        function fetchUserData(user_id) {
    if (user_id) {
        fetch(`get_user_info.php?user_id=${user_id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('user_name').innerText = 'ชื่อ: ' + data.first_name + ' ' + data.last_name;
                document.getElementById('user_username').innerText = 'Username: ' + data.username;
                document.getElementById('user_phone').innerText = 'เบอร์โทร: ' + data.phone;
                document.getElementById('username').value = data.username;
            });
    }
}


        function fetchMaintenData(mainten_id) {
            if (mainten_id) {
                fetch(`get_mainten_info.php?mainten_id=${mainten_id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('mainten_name').innerText = 'ชื่อ: ' + data.first_name + ' ' + data.last_name;
                        document.getElementById('mainten_username').innerText = 'Username: ' + data.username;
                        document.getElementById('mainten_phone').innerText = 'เบอร์โทร: ' + data.phone;
                    });
            }
        }

        function fetchOrgData(org_id) {
    if (org_id) {
        fetch(`get_org_info.php?org_id=${org_id}`)
            .then(response => response.json())
            .then(data => {
                // เก็บค่า org_name ลงใน hidden field
                document.getElementById('org_name').value = data.org_name;

                let buildingSelect = document.getElementById('building_name');
                let liftSelect = document.getElementById('lift_name');

                buildingSelect.innerHTML = '<option value="">เลือก Building</option>';
                data.buildings.forEach(function(building) {
                    buildingSelect.innerHTML += `<option value="${building.building_name}">${building.building_name}</option>`;
                });

                liftSelect.innerHTML = '<option value="">เลือก Lift</option>';
                data.lifts.forEach(function(lift) {
                    liftSelect.innerHTML += `<option value="${lift.lift_name}">${lift.lift_name}</option>`;
                });
            });
    }
}

        // เพิ่มช่องกรอกข้อมูลเครื่องมือ
        function addTool() {
            const container = document.getElementById('tools-container');
            const row = document.createElement('div');
            row.className = 'row mb-2';

            const toolCol = document.createElement('div');
            toolCol.className = 'col';
            const toolInput = document.createElement('input');
            toolInput.type = 'text';
            toolInput.className = 'form-control';
            toolInput.name = 'tools[]';
            toolInput.placeholder = 'ชื่อเครื่องมือ';
            toolCol.appendChild(toolInput);

            const quantityCol = document.createElement('div');
            quantityCol.className = 'col';
            const quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.className = 'form-control';
            quantityInput.name = 'quantities[]';
            quantityInput.placeholder = 'จำนวน';
            quantityCol.appendChild(quantityInput);

            row.appendChild(toolCol);
            row.appendChild(quantityCol);
            container.appendChild(row);
        }
    </script>
    <!-- --------------------------------------- -->
</body>
</html>
