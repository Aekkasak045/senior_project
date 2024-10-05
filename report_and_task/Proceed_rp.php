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
                                        <input type="text" name="tools[]" class="form-control" placeholder="Tool name" >
                                        <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1" >
                                        <button class="btn btn-danger" type="button" onclick="removeToolInput(this)" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>                                 
                                </div>
                                
                                <button class="btn btn-sm btn-secondary mb-3 add_tool" type="button" onclick="addToolInput()">Add Tool</button>

                                <h6 class="card-title">Assign Engineer</h6>
                                <div class="mb-3 box3">
                                    <select class="boxrole" name="engineer_id" id="engineer" required>
                                        <?php foreach ($engineers as $engineer): ?>
                                            <option value="<?php echo htmlspecialchars($engineer['id']); ?>"><?php echo htmlspecialchars($engineer['first_name'] . ' ' . $engineer['last_name']); ?></option>
                                        <?php endforeach; ?>]
                                    </select>
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
        newInputGroup.classList.add("input-group", "mb-2");

        // สร้าง input สำหรับชื่อเครื่องมือ
        var newToolInput = document.createElement("input");
        newToolInput.setAttribute("type", "text");
        newToolInput.setAttribute("name", "tools[]");
        newToolInput.setAttribute("class", "form-control");
        newToolInput.setAttribute("placeholder", "Tool name");

        // สร้าง input สำหรับจำนวน
        var newQuantityInput = document.createElement("input");
        newQuantityInput.setAttribute("type", "number");
        newQuantityInput.setAttribute("name", "quantities[]");
        newQuantityInput.setAttribute("class", "form-control");
        newQuantityInput.setAttribute("placeholder", "Quantity");
        newQuantityInput.setAttribute("min", "1");

        // สร้างปุ่มลบเป็นไอคอน
        var removeButton = document.createElement("button");
        removeButton.setAttribute("type", "button");
        removeButton.classList.add("btn", "btn-danger");
        removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>'; // ไอคอนถังขยะ
        removeButton.onclick = function() {
            removeToolInput(removeButton);
        };

        // เพิ่ม input ที่สร้างใหม่และปุ่มลบเข้าใน div
        newInputGroup.appendChild(newToolInput);
        newInputGroup.appendChild(newQuantityInput);
        newInputGroup.appendChild(removeButton);

        // เพิ่ม input group ใหม่ลงใน container
        inputContainer.appendChild(newInputGroup);

        // เปิดปุ่มลบของทุก input group
        enableRemoveButtons();
    }

    function removeToolInput(button) {
        // ลบ input group ที่ปุ่มลบนั้นอยู่
        button.parentElement.remove();

        // ตรวจสอบจำนวน input group
        enableRemoveButtons();
    }

    function enableRemoveButtons() {
        // ตรวจสอบจำนวนของ input group
        var inputGroups = document.querySelectorAll("#input-container .input-group");
        
        // ถ้ามีมากกว่า 1 input group ให้เปิดการใช้งานปุ่มลบ
        inputGroups.forEach(function(group) {
            var removeButton = group.querySelector("button");
            if (inputGroups.length > 1) {
                removeButton.disabled = false;
            } else {
                removeButton.disabled = true;
            }
        });
    }

    // เรียกใช้ฟังก์ชันนี้เมื่อเริ่มต้นเพื่อปิดปุ่มลบถ้ามี input group เดียว
    enableRemoveButtons();


    function validateForm() {
        var tools = document.querySelectorAll("input[name='tools[]']");
        var quantities = document.querySelectorAll("input[name='quantities[]']");
        
        for (var i = 0; i < tools.length; i++) {
            var tool = tools[i].value.trim();
            var quantity = quantities[i].value.trim();

            // ตรวจสอบว่าช่อง tool หรือ quantity ว่างหรือไม่
            if (tool === "" || quantity === "") {
                alert("Please fill out both Tool name and Quantity for all inputs.");
                return false; // หยุดการส่งฟอร์ม
            }
        }
        return true; // ส่งฟอร์มถ้าข้อมูลถูกต้อง
    }
</script>

<script src="scripts.js"></script>
