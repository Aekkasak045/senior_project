<?php
require("inc_db.php");
include("update_task_status.php");
$report_id = $_GET["rp_id"];

// Ensure report ID is provided
if (!isset($report_id)) {
    die('Report ID not provided.');
}

// Fetch engineers
$engi = "SELECT id, first_name, last_name FROM users WHERE role='mainten'";
$result = $conn->query($engi);
$engineers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $engineers[] = $row;
    }
} else {
    echo "No engineers found";
}
// ดึงข้อมูลจากตาราง tools
$sql_tools = "SELECT tool_id, tool_name FROM tools";
$tools_result = $conn->query($sql_tools); 
// Fetch report details
$sql = "SELECT report.rp_id, report.detail, report.date_rp, report.user_id,
        users.username, users.first_name, users.last_name, users.email, users.phone, users.role,users.user_img,
        organizations.org_name, building.building_name, lifts.lift_name 
        FROM report 
        INNER JOIN users ON report.user_id = users.id 
        INNER JOIN organizations ON report.org_id = organizations.id
        INNER JOIN building ON report.building_id = building.id
        INNER JOIN lifts ON report.lift_id = lifts.id
        WHERE report.rp_id = $report_id";
$rs = mysqli_query($conn, $sql);

// Check if query execution was successful
if (!$rs) {
    die('Query Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($rs);

// Ensure the row is not empty
if (!$row) {
    die('No data found for the provided report ID.');
}

session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location:../login/login.php');
    exit(); // Add exit to stop the script after redirect
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:../login/login.php');
    exit(); // Add exit to stop the script after redirect
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="proceed.css" />
    <title>Lift RMS</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php'); ?>

    <div class="container box-outer1">
        <div class="card box-outer2">
            <div class="text-white">
                <h5 class="mb-0">Create Task: <?php echo htmlspecialchars($row["rp_id"]); ?></h5>
            </div>
            <div class="card-body">
            <form action="save_task.php" method="post" onsubmit="return validateForm()">
                <div class="row">
                    <!-- User Information -->
                    <div class="col-md-6 mb-4">
                            <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row["rp_id"]); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($row["username"]); ?>">
                            <input type="hidden" name="org_name" value="<?php echo htmlspecialchars($row["org_name"]); ?>">
                            <input type="hidden" name="building_name" value="<?php echo htmlspecialchars($row["building_name"]); ?>">
                            <input type="hidden" name="lift_name" value="<?php echo htmlspecialchars($row["lift_name"]); ?>">
                            <div class="card mb-3">
                                <div class="card-body ">
                                    <h6 class="card-title">User Information</h6>
                                    <?php if (!empty($row["user_img"])): ?>
                                        <div class="text-center mb-3">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row["user_img"]); ?>" alt="User Image" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                    <p class="textinfo"><strong>Username:</strong> <?php echo htmlspecialchars($row["username"]); ?></p>
                                    <p class="textinfo"><strong >Name:</strong> <?php echo htmlspecialchars($row["first_name"]) . ' ' . htmlspecialchars($row["last_name"]); ?></p>
                                    <p class="textinfo"><strong>Phone:</strong> <?php echo htmlspecialchars($row["phone"]); ?></p>
                                    <p class="textinfo"><strong>Email:</strong> <?php echo htmlspecialchars($row["email"]); ?></p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body ">
                                    <h6 class="card-title">Location</h6>
                                    <div class="body_location">
                                    <div class="img_location">
                                        <img src="img/building.png" class="img_fluid_location" alt="location-icon">
                                    </div>
                                        <div class="card-body" style="padding: 0;">
                                            <p class="textinfo"><strong>Organization:</strong> <?php echo htmlspecialchars($row["org_name"]); ?></p>
                                            <p class="textinfo"><strong>Building:</strong> <?php echo htmlspecialchars($row["building_name"]); ?></p>
                                            <p class="textinfo"><strong>Lift:</strong> <?php echo htmlspecialchars($row["lift_name"]); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Task Details -->
                    <div class="col-md-6 mb-4">
                        <div class="card mb-3">
                            <div class="card-body">
                            <form action="save_task.php" method="post"></form>
                                <h6 class="card-title">Details</h6>
                                <div class="mb-3">
                                    <textarea name="detail" class="form-control card_color2" rows="4" placeholder="Enter details"><?php echo htmlspecialchars($row["detail"]); ?></textarea>
                                </div>
                                

                                <!-- Tools Used Section -->
                                <h6 class="card-title">Tools Used</h6>
                                <div id="input-container" class="mb-3">
                                    <div class="input-group mb-2">
                                        <!-- ใช้ select dropdown สำหรับเลือกเครื่องมือ -->
                                        <select name="tools[]" class="form-select">
                                            <option value="">เลือกเครื่องมือ</option>
                                            <?php 
                                            // ดึงข้อมูลเครื่องมือจากตาราง tools
                                            $sql_tools = "SELECT tool_name FROM tools";
                                            $result_tools = $conn->query($sql_tools);

                                            while ($tool = $result_tools->fetch_assoc()) { ?>
                                                <option value="<?php echo $tool['tool_name']; ?>"><?php echo $tool['tool_name']; ?></option>
                                            <?php } ?>
                                        </select>

                                        <!-- ฟิลด์สำหรับใส่จำนวน -->
                                        <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1">

                                        <!-- ปุ่มลบ -->
                                        <button class="btn btn-danger" type="button" onclick="removeToolInput(this)" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>                                 
                                </div>

                                <!-- ปุ่มเพิ่มเครื่องมือ -->
                                <button class="btn btn-sm btn-secondary mb-3 add_tool" type="button" onclick="addToolInput()">Add Tool</button>

                                <!-- ฟิลด์สำหรับเลือกวันที่และเวลาเริ่มงาน (24 ชม.) -->
                                <div class="mb-3">
                                    <label for="task_start_date" class="form-label">วันที่และเวลาเริ่มงาน:</label>
                                    <input type="datetime-local" class="form-control" id="task_start_date" name="task_start_date" required>
                                </div>

                                <h6 class="card-title">Assign Engineer</h6>
                                    <div class="mb-3 box3">
                                        <select class="boxrole" name="engineer_id" id="engineer" onchange="fetchEngineerData(this.value)" required>
                                            <option value="">เลือกช่าง</option>
                                            <?php foreach ($engineers as $engineer): ?>
                                                <option value="<?php echo htmlspecialchars($engineer['id']); ?>"><?php echo htmlspecialchars($engineer['first_name'] . ' ' . $engineer['last_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div id="engineer_info" class="mb-3">
                                        <h6 class="card-title">Engineer Information</h6>
                                        <p id="engineer_name" class="textinfo"></p>
                                        <p id="engineer_phone" class="textinfo"></p>
                                        <p id="engineer_email" class="textinfo"></p>
                                        <img id="engineer_image" src="" alt="Engineer Image" style="max-width: 100px; display: none;">
                                    </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <input class="btn btn-primary create" type="submit" name="edit" value="Create Task">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Close the form -->
                </form>
                
                <!-- Delete Report Button -->
                <form action="delete_report.php" method="post" onsubmit="return confirm('Are you sure you want to delete this report?');" class="text-center mt-3 delete_task">
                    <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row['rp_id']); ?>">
                    <button class="btn btn-danger delete" type="submit">Delete Report</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function addToolInput() {
        var inputContainer = document.getElementById("input-container");

        // สร้าง div ใหม่สำหรับ input group ใหม่
        var newInputGroup = document.createElement("div");
        newInputGroup.classList.add("input-group", "mb-2", "toolField");

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
        removeButton.classList.add("btn", "btn-danger", "removeField");
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

        // อัปเดตสถานะปุ่มลบ
        updateRemoveButtons();
    }

    function removeToolInput(button) {
        var inputContainer = document.getElementById("input-container");
        if (inputContainer.children.length > 1) {
            button.parentElement.remove();
            updateRemoveButtons();
        }
    }

    // ฟังก์ชันสำหรับอัปเดตสถานะปุ่มลบ
    function updateRemoveButtons() {
        var removeButtons = document.querySelectorAll('.removeField');
        var toolFields = document.querySelectorAll('.toolField');

        // ถ้ามีมากกว่า 1 ฟิลด์ ให้เปิดใช้งานปุ่มลบ ถ้ามีแค่ 1 ปิดการใช้งานปุ่มลบ
        removeButtons.forEach(button => {
            if (toolFields.length >0) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });
    }

    // เรียกใช้เพื่ออัปเดตสถานะปุ่มลบเมื่อโหลดหน้า
    updateRemoveButtons();



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
</script>

<script src="scripts.js"></script>
<script>
    function fetchEngineerData(engineer_id) {
        if (engineer_id) {
            // ส่ง request ไปยังไฟล์ PHP เพื่อดึงข้อมูลของช่าง
            fetch('get_mainten_info.php?engineer_id=' + engineer_id)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('engineer_name').textContent = 'Name: ' + data.first_name + ' ' + data.last_name;
                        document.getElementById('engineer_phone').textContent = 'Phone: ' + data.phone;
                        document.getElementById('engineer_email').textContent = 'Email: ' + data.email;

                        // แสดงรูปภาพถ้ามี
                        if (data.user_img) {
                            document.getElementById('engineer_image').src = 'data:image/jpeg;base64,' + data.user_img;
                            document.getElementById('engineer_image').style.display = 'block';
                        } else {
                            document.getElementById('engineer_image').style.display = 'none';
                        }
                    } else {
                        alert('Engineer data not found');
                    }
                })
                .catch(error => console.error('Error fetching engineer data:', error));
        }
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