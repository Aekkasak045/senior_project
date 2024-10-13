<!-- ระบบฐานข้อมูล -->
<?php
require("inc_db.php"); // เรียกใช้ไฟล์ฐานข้อมูล

// ดึง rp_id ที่มากที่สุดจากตาราง task และ report
$sql_latest_report = "
    SELECT GREATEST(
        (SELECT IFNULL(MAX(rp_id), 0) FROM task),
        (SELECT IFNULL(MAX(rp_id), 0) FROM report)
    ) AS latest_rp_id";

// รันคำสั่ง SQL
$result_latest_report = $conn->query($sql_latest_report);

// ดึงค่า rp_id ที่มากที่สุด
if ($result_latest_report->num_rows > 0) {
    $latest_report = $result_latest_report->fetch_assoc()['latest_rp_id'];
    echo "rp_id ที่มากที่สุดคือ: " . $latest_report;
} else {
    echo "ไม่พบข้อมูล rp_id ในทั้งสองตาราง";
}

// ดึงข้อมูล Organization
$sql_org = "SELECT id as org_id, org_name FROM organizations";
$org_result = $conn->query($sql_org);

// ดึงข้อมูลผู้ใช้
$sql_users = "SELECT id,username, first_name, last_name,user_img FROM users";
$users_result = $conn->query($sql_users);

// ดึงข้อมูลช่าง
$sql_mainten = "SELECT id, first_name, last_name,user_img FROM users WHERE role = 'mainten'";
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
    $task_start_date = $_POST['task_start_date']; 
    $formatted_task_start_date = date("d/m/Y H:i", strtotime($task_start_date));
    $assign = 'ได้หมอบหมายงาน และวันเวลาที่ต้องเข้าไปดำเนินการคือ '.$formatted_task_start_date;

    // จัดการ tools และ quantities เป็น JSON
    $tools_data = [];
    foreach ($tools as $index => $tool) {
        if (!empty(trim($tool)) && !empty(trim($quantities[$index]))) {
            $tools_data[] = ['tool' => $tool, 'quantity' => (int)$quantities[$index]];
        }
    }
    $tools_json = json_encode($tools_data);

    $sql = "INSERT INTO task (tk_data, rp_id, user_id, user, mainten_id, org_name, building_name, lift_id, tools, tk_status,task_start_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siisisssss", $task_detail, $rp_id, $user_id, $username, $mainten_id, $org_name, $building_name, $lift_name, $tools_json,$task_start_date);

if ($stmt->execute()) {
    // ดึง task_id ของงานที่เพิ่งถูกสร้างขึ้น
    $task_id = $stmt->insert_id; 

    // Insert ข้อมูลลงในตาราง task_status
    $insert_status = "INSERT INTO task_status (tk_id, status, time, detail) VALUES (?, 'assign', ?, ?)";
    $stmt_status = $conn->prepare($insert_status);
    if (!$stmt_status) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt_status->bind_param("iss", $task_id, $time,$assign);

    if ($stmt_status->execute()) {
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

// ดึงข้อมูลจากตาราง tools
$sql_tools = "SELECT tool_id, tool_name FROM tools";
$tools_result = $conn->query($sql_tools);

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
    <link rel="stylesheet" href="add_task.css" />
</head>
<body class="background1">
<?php require('../navbar/navbar.php'); ?>
    <div class="box-outer1">
        <div class="box-outer2">
            <div class="topinfo_task">
                <h5 class="topic">Create Task</h5>
                <a href="task_list.php" class="back">Back</a>
            </div>
            <div class="sec1">
            <form action="" method="POST" onsubmit="return validateForm() && validate()">
                <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">
                        <!-- Report ID (Auto fill เป็นค่าล่าสุด) -->
                        <div class="box0">
                        <label for="rp_id" class="form_text">Report ID : </label>
                        <div class="mb-3 box3">
                            <input type="text" class="boxrole" id="rp_id" name="rp_id" value="<?php echo $latest_report+1; ?>" >
                        </div>
                        </div>

                        <!-- เลือกผู้ใช้ -->
                        <div class="box0">
                        <label for="user_id" class="form_text">เลือกผู้ใช้ : </label>
                        <div class="mb-3 box3">
                            <select class="boxrole" id="user_id" name="user_id" onchange="fetchUserData(this.value)" required>
                                <option value="">เลือกผู้ใช้</option>
                                <?php while ($user = $users_result->fetch_assoc()) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['id'] . " - " . $user['first_name'] . " " . $user['last_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>
                        

                        <!-- Hidden field สำหรับเก็บ username -->
                        <input type="hidden" id="username" name="username" value="">

                        <!-- แสดงข้อมูลผู้ใช้ -->
                        <div id="user_info" class="mb-3">
                            <h5 class="data_text">ข้อมูลผู้แจ้ง : </h5>
                            <p id="user_name" class="data_body_text"></p>
                            <p id="user_username" class="data_body_text"></p>
                            <p id="user_phone" class="data_body_text"></p>
                            <p id="user_email" class="data_body_text"></p> 
                        </div>


                        <!-- เลือก Organization -->
                        <div class="box0">
                        <label for="org_id" class="form_text">Organization :</label>
                        <div class="mb-3 box3">
                            <select class="boxrole" id="org_id" name="org_id" onchange="fetchOrgData(this.value)" required>
                                <option value="">เลือก Organization</option>
                                <?php while ($org = $org_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $org['org_id']; ?>"><?php echo $org['org_id'] . " - " . $org['org_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>

                        <input type="hidden" id="org_name" name="org_name" value="">

                        <!-- เลือก Building (ขึ้นอยู่กับ Organization) -->
                        <div class="box0">
                        <label for="building_name" class="form_text">Building : </label>
                        <div class="mb-3 box3">
                            <select class="boxrole" id="building_name" name="building_name" required>
                                <option value="">เลือก Building</option>
                            </select>
                        </div>
                        </div>

                        <!-- เลือก Lift (ขึ้นอยู่กับ Organization) -->
                        <div class="box0">
                        <label for="lift_name" class="form_text">Lift : </label>
                        <div class="mb-3 box3">
                            <select class="boxrole" id="lift_name" name="lift_name" required>
                                <option value="">เลือก Lift</option>
                            </select>
                        </div>
                        </div>

                        <!-- รายละเอียดงาน -->
                        <label for="detail" class="data_text">รายละเอียดงาน : </label>
                        <div class="mb-3">
                            <textarea class="form-control card_color2" id="detail" name="detail" rows="3" required></textarea>
                        </div>

                    </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">

                        <!-- เลือกช่าง -->
                        <div class="box0">
                        <label for="mainten_id" class="form_text">เลือกช่าง : </label>
                        <div class="mb-3 box3">
                            <select class="boxrole" id="mainten_id" name="mainten_id" onchange="fetchMaintenData(this.value)" required>
                                <option value="">เลือกช่าง</option>
                                <?php while ($mainten = $mainten_result->fetch_assoc()) { ?>
                                <option value="<?php echo $mainten['id']; ?>"><?php echo $mainten['id'] . " - " . $mainten['first_name'] . " " . $mainten['last_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>

                        <!-- แสดงข้อมูลช่าง -->
                        <div id="mainten_info" class="mb-3">
                            <h5 class="data_text">ข้อมูลช่าง : </h5>
                            <p id="mainten_name" class="data_body_text"></p>
                            <p id="mainten_username" class="data_body_text"></p>
                            <p id="mainten_phone" class="data_body_text"></p>
                            <p id="mainten_email" class="data_body_text"></p> 
                        </div>

                        <!-- ส่วนเครื่องมือที่ใช้ -->
                        <div class="mb-3">
                            <label for="tools" class="form_text">เครื่องมือที่ใช้ : </label>
                            <div id="input-container" class="mb-3">
                                <div class="input-group mb-2">
                                    <!-- สร้าง select dropdown เพื่อให้เลือกเครื่องมือจากตาราง tools -->
                                    <select name="tools[]" class="form-select">
                                        <option value="">เลือกเครื่องมือ</option>
                                        <?php while ($tool = $tools_result->fetch_assoc()) { ?>
                                            <option value="<?php echo $tool['tool_name']; ?>"><?php echo $tool['tool_name']; ?></option>
                                        <?php } ?>
                                    </select>

                                    <!-- ฟิลด์สำหรับใส่จำนวนเครื่องมือ -->
                                    <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1">

                                    <!-- ปุ่มลบ -->
                                    <button class="btn btn-danger" type="button" onclick="removeToolInput(this)" disabled>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-secondary mb-3 add_tool" type="button" onclick="addToolInput()">Add Tool</button>
                        </div>

                    <!-- ฟิลด์สำหรับเลือกวันที่และเวลาเริ่มงาน (24 ชม.) -->
                    <div class="box0">
                        <label for="task_start_date" class="form_text">วันเวลาเริ่มงาน:</label>
                        <div class="mb-3 box3">
                        <input type="datetime-local" class="boxrole" id="task_start_date" name="task_start_date" required>
                        </div>
                    </div>
                    <div class="button_create">
                        <button type="submit" class="btn btn-primary create">Create</button></div>
                    </div>

                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- ฟังก์ชั้นการเรียกตัวแปร -->
    <script>
        function fetchUserData(user_id) {
            if (user_id) {
                fetch(`get_user_info.php?user_id=${user_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Error fetching user data:', data.error);
                        } else {
                            document.getElementById('user_name').innerText = 'Name: ' + data.first_name + ' ' + data.last_name;
                            document.getElementById('user_username').innerText = 'Username: ' + data.username;
                            document.getElementById('user_phone').innerText = 'Phone: ' + data.phone;
                            document.getElementById('user_email').innerText = 'Email: ' + data.email;
                            document.getElementById('username').value = data.username;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function fetchMaintenData(mainten_id) {
            if (mainten_id) {
                fetch(`get_mainten_info.php?mainten_id=${mainten_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Error fetching mainten data:', data.error);
                        } else {
                            document.getElementById('mainten_name').innerText = 'Name: ' + data.first_name + ' ' + data.last_name;
                            document.getElementById('mainten_username').innerText = 'Username: ' + data.username;
                            document.getElementById('mainten_phone').innerText = 'Phone: ' + data.phone;
                            document.getElementById('mainten_email').innerText = 'Email: ' + data.email;
                        }
                    })
                    .catch(error => console.error('Error:', error));
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
// เก็บตัวเลือกเครื่องมือเป็น JavaScript array
var toolOptions = `
    <option value="">เลือกเครื่องมือ</option>
    <?php 
        $tools_result = $conn->query($sql_tools); // เรียก query ใหม่เพื่อให้ใช้งานได้ใน JavaScript
        while ($tool = $tools_result->fetch_assoc()) { ?>
        <option value="<?php echo $tool['tool_name']; ?>"><?php echo $tool['tool_name']; ?></option>
    <?php } ?>
`;

function addToolInput() {
    var inputContainer = document.getElementById("input-container");

    // สร้าง div ใหม่สำหรับ input group ใหม่
    var newInputGroup = document.createElement("div");
    newInputGroup.classList.add("input-group", "mb-2");

    // สร้าง select dropdown สำหรับเลือกเครื่องมือ
    var newToolSelect = document.createElement("select");
    newToolSelect.setAttribute("name", "tools[]");
    newToolSelect.classList.add("form-select");

    // เพิ่มตัวเลือก "เลือกเครื่องมือ"
    var defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "เลือกเครื่องมือ";
    newToolSelect.appendChild(defaultOption);

    // เพิ่มตัวเลือกเครื่องมือจาก PHP (ทำผ่าน JavaScript)
    <?php 
    // ดึงข้อมูลเครื่องมือจากฐานข้อมูลและสร้างตัวเลือกใน dropdown
    $sql_tools = "SELECT tool_name FROM tools";
    $result_tools = $conn->query($sql_tools);
    while ($tool = $result_tools->fetch_assoc()) { ?>
        var option = document.createElement("option");
        option.value = "<?php echo $tool['tool_name']; ?>";
        option.textContent = "<?php echo $tool['tool_name']; ?>";
        newToolSelect.appendChild(option);
    <?php } ?>

    // สร้าง input สำหรับจำนวน
    var newQuantityInput = document.createElement("input");
    newQuantityInput.setAttribute("type", "number");
    newQuantityInput.setAttribute("name", "quantities[]");
    newQuantityInput.setAttribute("class", "form-control");
    newQuantityInput.setAttribute("placeholder", "Quantity");
    newQuantityInput.setAttribute("min", "1");

    // สร้างปุ่มลบ
    var removeButton = document.createElement("button");
    removeButton.setAttribute("type", "button");
    removeButton.classList.add("btn", "btn-danger");
    removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    removeButton.onclick = function() {
        removeToolInput(removeButton);
    };

    // เพิ่ม select dropdown และ input สำหรับจำนวนเข้าใน div
    newInputGroup.appendChild(newToolSelect);
    newInputGroup.appendChild(newQuantityInput);
    newInputGroup.appendChild(removeButton);

    // เพิ่ม input group ใหม่ลงใน container
    inputContainer.appendChild(newInputGroup);

    // เปิดปุ่มลบของทุก input group
    enableRemoveButtons();
}
function removeToolInput(button) {
    var inputContainer = document.getElementById("input-container");

    // ตรวจสอบจำนวน input-group ที่มีอยู่
    var inputGroups = inputContainer.getElementsByClassName("input-group");

    if (inputGroups.length > 1) {
        // ลบ input-group ที่เชื่อมโยงกับปุ่มนี้
        button.parentElement.remove();
    }

    // หลังจากลบแล้ว ตรวจสอบอีกครั้งว่าถ้าเหลือ 1 input group ให้ปิดปุ่มลบ
    enableRemoveButtons();
}

function enableRemoveButtons() {
    var inputContainer = document.getElementById("input-container");
    var inputGroups = inputContainer.getElementsByClassName("input-group");

    // เปิดใช้งานปุ่มลบเมื่อมีมากกว่า 1 input-group
    for (var i = 0; i < inputGroups.length; i++) {
        var removeButton = inputGroups[i].querySelector("button");
        if (inputGroups.length > 1) {
            removeButton.disabled = false;
        } else {
            removeButton.disabled = true;
        }
    }
}

// เรียกใช้ฟังก์ชัน enableRemoveButtons เมื่อเริ่มต้น
enableRemoveButtons();

    function validate() {
        var tools = document.querySelectorAll("select[name='tools[]']");
        var quantities = document.querySelectorAll("input[name='quantities[]']");
        
        for (var i = 0; i < tools.length; i++) {
            var tool = tools[i].value.trim();
            var quantity = quantities[i].value.trim();

            // ตรวจสอบว่าช่อง tool หรือ quantity ว่างหรือไม่
            if ((tool !== "" && quantity === "") || (tool === "" && quantity !== "")) {
                alert("Please fill out both Tool name and Quantity for all inputs.");
                return false; // หยุดการส่งฟอร์ม
            }
        }
        return true; // ส่งฟอร์มถ้าข้อมูลถูกต้อง
    }


    function validateForm() {
        var tools = document.querySelectorAll("input[name='tools[]']");
        var quantities = document.querySelectorAll("input[name='quantities[]']");
        
        for (var i = 0; i < tools.length; i++) {
            var tool = tools[i].value.trim();
            var quantity = quantities[i].value.trim();

            // ตรวจสอบว่าช่อง tool หรือ quantity ว่างหรือไม่
            if ((tool !== "" && quantity === "") || (tool === "" && quantity !== "")) {
                alert("Please fill out both Tool name and Quantity for all inputs.");
                return false; // หยุดการส่งฟอร์ม
            }
        }
        return true; // ส่งฟอร์มถ้าข้อมูลถูกต้อง
    }

    function validateForm() {
        var startDate = document.getElementById("task_start_date").value;
        var currentDate = new Date();

        // แปลงวันที่เริ่มงานเป็นรูปแบบ Date
        var selectedDate = new Date(startDate);

        if (selectedDate < currentDate) {
            alert("กรุณาเลือกวันที่และเวลาเริ่มงานที่ถูกต้อง");
            return false; // หยุดการส่งฟอร์ม
        }

        return true; // ส่งฟอร์มถ้าข้อมูลถูกต้อง
    }

    </script>
    <!-- --------------------------------------- -->
</body>
</html>