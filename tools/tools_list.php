<?php
require("inc_db.php");
include("function.php");
// include("update_task_status.php");

$sql = "SELECT * FROM tools";
$rs = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="task.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Lift RMS</title>
</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php') ?>

    <div class="box-outer1">
        <div class="box-outer2">
            <section class="header_Table">
                <p class="User_information">Task information</p>
                <!-- ########################### Search & Filter ########################### -->
                <div class="search_filter">
                <button class="btn btn-primary addtask" data-bs-toggle="modal" data-bs-target="#addToolModal">Add Tool</button>

                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_task">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup"><i class="fa-solid fa-filter"></i></button>
                    <div id="popupDialog">
                            <p class="filter">Filter</p>
                            <form action="" method="POST">
                                <div class="status-filter-box">
                                    <label class="status-font">ID : &nbsp;</label>
                                        <input class="idm" type="number" id="number" name="id_min" placeholder="Min ID">
                                        To
                                        <input class="idm" type="number" id="number" name="id_max" placeholder="Max ID">
                                    <br>
                                    <br>
                                    <label class="status-font">Option ID : </label>
                                    <div class="idc">
                                        <input type="radio" name="id" value="Lowest_to_Highest"> Lowest to Highest
                                        <br>
                                        <input type="radio" name="id" value="Highest_to_Lowest"> Highest to Lowest
                                        </div>
                                    <label class="status-font">Status : </label>
                                    <div class="status-filter">
                                        <input type="radio" name="status" value="1"> มอบหมาย
                                        <br>
                                        <input type="radio" name="status" value="2"> รอดำเนินการ
                                        <br>
                                        <input type="radio" name="status" value="3"> กำลังดำเนินการ
                                        <br>
                                        <input type="radio" name="status" value="4"> ดำเนินการเสร็จสิ้น
                                        <br>
                                    </div>
                                </div>
                                <br>
                            <button type="submit" name="used_filter" class="used-filter" id="filter_text">Used</button>
                            <label class="cencel-filter" onclick="openPop()">Close</label>
                            </form>
                        </div>
                        <?php if(isset($_POST['used_filter']))
                {   
                    $sql = filter_task();
                    $rs = mysqli_query($conn, $sql);
                }                    
                ?>
                </div>
                <!-- ####################################################################### -->
            </section>
            <div class="sec1">
                <table class="table1" id="table-data">
                    <thead>
                        <tr class="table-lift">
                            <th class="row-1 row-ID">ID</th>
                            <th class="row-2 row-Name">Name</th>
                            <th class="row-3 row-Name">Cost</th>
                            <th class="row-9 row-Action">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody id="showdata">
                        <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                            <tr class="table-lift">
                                <td><?php echo htmlspecialchars($row['tool_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['tool_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['cost']); ?></td>
                                <td class="parent-container">
                                    <a href="#" class="btn btn-success" onclick="editTool('<?php echo $row['tool_id']; ?>', '<?php echo $row['tool_name']; ?>', '<?php echo $row['cost']; ?>')" data-bs-toggle="modal" data-bs-target="#editModal">แก้ไข</a>
                                    <a href="?delete_tool_id=<?php echo htmlspecialchars($row["tool_id"]); ?>" class="btn btn-danger">ลบ</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   <!-- Modal for Edit Tool -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขเครื่องมือ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editToolForm" method="POST" action="">
                    <input type="hidden" name="tool_id" id="tool_id">
                    <div class="mb-3">
                        <label for="tool_name" class="form-label">ชื่อเครื่องมือ:</label>
                        <input type="text" class="form-control" id="tool_name" name="tool_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="tool_cost" class="form-label">ราคา:</label>
                        <input type="number" class="form-control" id="tool_cost" name="tool_cost" required>
                    </div>
                    <button type="submit" name="update_tool" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addToolModal" tabindex="-1" aria-labelledby="addToolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToolModalLabel">Add Tools</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addToolForm" method="POST" action="">

                    <!-- ฟิลด์เพิ่มเครื่องมือแบบหลายรายการ -->
                    <div id="toolFields">
                        <div class="mb-3">
                            <label for="tool_name[]" class="form-label">Tool Name:</label>
                            <input type="text" class="form-control" name="tool_name[]" required>
                        </div>
                        <div class="mb-3">
                            <label for="tool_cost[]" class="form-label">Cost:</label>
                            <input type="number" class="form-control" name="tool_cost[]" required>
                        </div>
                    </div>

                    <!-- ปุ่มเพิ่มฟิลด์ -->
                    <button type="button" class="btn btn-secondary" onclick="addToolField()">Add More Tools</button>

                    <button type="submit" name="save_tools" class="btn btn-primary mt-3">Save Tools</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="scripts.js"></script>
<script>
        function editTool(tool_id, tool_name, tool_cost) {
            document.getElementById('tool_id').value = tool_id;
            document.getElementById('tool_name').value = tool_name;
            document.getElementById('tool_cost').value = tool_cost;
        }

        // ฟังก์ชันเพิ่มฟิลด์เครื่องมือ
    function addToolField() {
        const toolFields = document.getElementById('toolFields');
        const newField = `
            <div class="mb-3">
                <label for="tool_name[]" class="form-label">Tool Name:</label>
                <input type="text" class="form-control" name="tool_name[]" required>
            </div>
            <div class="mb-3">
                <label for="tool_cost[]" class="form-label">Cost:</label>
                <input type="number" class="form-control" name="tool_cost[]" required>
            </div>
        `;
        toolFields.insertAdjacentHTML('beforeend', newField);
    }
</script>
</html>





<?php

// จัดการข้อมูลการเพิ่มเครื่องมือ
if (isset($_POST['save_tools'])) {
    $tool_names = $_POST['tool_name'];
    $tool_costs = $_POST['tool_cost'];

    // เตรียมการ insert ข้อมูลหลายรายการพร้อมกัน
    $stmt = $conn->prepare("INSERT INTO tools (tool_name, cost) VALUES (?, ?)");
    foreach ($tool_names as $index => $tool_name) {
        $tool_cost = $tool_costs[$index];
        $stmt->bind_param("sd", $tool_name, $tool_cost);
        $stmt->execute();
    }
    $stmt->close();

    echo "<script>alert('Tools added successfully!'); window.location.href='tools_list.php';</script>";
}

if (isset($_GET['delete_tool_id'])) {
    $tool_id = $_GET['delete_tool_id'];

    // Delete tool from the database
    $delete_sql = "DELETE FROM tools WHERE tool_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $tool_id);

    if ($stmt->execute()) {
        echo "<script>alert('ลบเครื่องมือสำเร็จ!'); window.location.href='tools_list.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบเครื่องมือ!');</script>";
    }

    $stmt->close();
}



// Handle Update Tool
if (isset($_POST['update_tool'])) {
    $tool_id = $_POST['tool_id'];
    $tool_name = $_POST['tool_name'];
    $tool_cost = $_POST['tool_cost'];

    // Update tool in the database
    $update_sql = "UPDATE tools SET tool_name = ?, cost = ? WHERE tool_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdi", $tool_name, $tool_cost, $tool_id);

    if ($stmt->execute()) {
        echo "<script>alert('แก้ไขเครื่องมือสำเร็จ!'); window.location.href='tools_list.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการแก้ไขเครื่องมือ!');</script>";
    }

    $stmt->close();
}
?>
