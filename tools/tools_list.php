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
                <p class="User_information">Tools</p>
                <!-- ########################### Search & Filter ########################### -->
                <div class="search_filter">
                    <button class="addtask" data-bs-toggle="modal" data-bs-target="#addToolModal"><i class="fa-solid fa-plus fa-xl pluse"></i> Add Tool</button>

                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_tool">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup"><i class="fa-solid fa-filter"></i></button>
                    <div id="popupDialog">
                        <p class="filter">Filter</p>
                        <form action="" method="POST">
                            <div class="status-filter-box">
                                <label class="status-font">Tools : &nbsp;</label>
                                <input class="idt" type="text" id="tools" name="tools" placeholder="Tools">
                                <br>
                                <br>
                                <label class="status-font">ID : &nbsp;</label>
                                <input class="idm" type="number" id="number" name="id_min" placeholder="Min ID">
                                To
                                <input class="idm" type="number" id="number" name="id_max" placeholder="Max ID">
                                <br>
                                <br>
                                <label class="status-font">Price : &nbsp;</label>
                                <input class="idp" type="number" id="number" name="p_min" placeholder="Min Price">
                                To
                                <input class="idp" type="number" id="number" name="p_max" placeholder="Max Price">
                                <br>
                                <br>
                                <label class="status-font">Option : </label>
                                <div class="idc">
                                    <input type="radio" name="option" value="ID_L"> ID Lowest to Highest
                                    <br>
                                    <input type="radio" name="option" value="ID_H"> ID Highest to Lowest
                                    <br>
                                    <input type="radio" name="option" value="P_L"> Price Highest to Lowest
                                    <br>
                                    <input type="radio" name="option" value="P_H"> Price Highest to Lowest
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="used_filter" class="used-filter" id="filter_text">Used</button>
                            <label class="cencel-filter" onclick="openPop()">Close</label>
                        </form>
                    </div>
                    <?php if (isset($_POST['used_filter'])) {
                        $sql = filter_tools();
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
                            <th class="row-3 row-Cost">Cost</th>
                            <th class="row-9 row-Action">Action</th>

                        </tr>
                    </thead>
                    <tbody id="showdata">
                        <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                            <tr class="table-lift">
                                <td class="parent-container1"><?php echo htmlspecialchars($row['tool_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['tool_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['cost']); ?></td>
                                <td class="parent-container">
                                    <a href="#" class="btn btn-success editTool" onclick="editTool('<?php echo $row['tool_id']; ?>', '<?php echo $row['tool_name']; ?>', '<?php echo $row['cost']; ?>')" data-bs-toggle="modal" data-bs-target="#editModal">แก้ไข</a>
                                    <a href="?delete_tool_id=<?php echo htmlspecialchars($row["tool_id"]); ?>" class="btn btn-danger editTool">ลบ</a>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editToolForm" method="POST" action="">
                        <input type="hidden" name="tool_id" id="tool_id">
                        <div class="tool_name">
                            <div class="mb-3 name0">
                                <label class="form-label name_cost">ชื่อเครื่องมือ:</label>
                            </div>
                            <div class="mb-3 name0">
                                <label class="form-label name_cost">ราคา:</label>
                            </div>
                        </div>
                        <div class="tool">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="tool_name" name="tool_name" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" id="tool_cost" name="tool_cost" required>
                            </div>
                        </div>
                        <br>
                        <div class="save">
                            <button type="submit" name="update_tool" class="btn savetool">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Form for Adding Tools -->
    <div class="modal fade" id="addToolModal" tabindex="-1" aria-labelledby="addToolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToolModalLabel">เพิ่มเครื่องมือ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <div class="modal-body"> -->
                <form id="addToolForm" method="POST" action="">
                    <div id="toolFields">
                        <div class="tool_name">
                            <div class="mb-3 name">
                                <label class="form-label name_cost">ชื่อเครื่องมือ:</label>
                            </div>
                            <div class="mb-3 name">
                                <label class="form-label name_cost">ราคา:</label>
                            </div>
                        </div>
                        <div class="toolField tool">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="tool_name[]" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" name="tool_cost[]" required>
                            </div>
                            <!-- ปุ่มลบฟิลด์ -->
                            <button type="button" class="btn btn-danger removeField" disabled><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <!-- ปุ่มเพิ่มฟิลด์เครื่องมือ -->
                    <button type="button" class="btn addtool" onclick="addToolField()">Add Tools</button>
                    <div class="save">
                        <button type="submit" name="save_tools" class="btn savetool">Save Tools</button>
                    </div>
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

    // ฟังก์ชันเพิ่มฟิลด์เครื่องมือใหม่
    function addToolField() {
        const toolFields = document.getElementById('toolFields');
        const newField = document.createElement('div');
        newField.classList.add('toolField', 'tool');
        newField.innerHTML = `
            <div class="mb-3">
                <input type="text" class="form-control" name="tool_name[]" required>
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="tool_cost[]" required>
            </div>
                <button type="button" class="btn btn-danger removeField" disabled><i class="fas fa-trash-alt"></i></button>
        `;


        // เพิ่มฟิลด์ใหม่เข้าไปใน DOM
        toolFields.appendChild(newField);
        // ตรวจสอบจำนวนฟิลด์ และเปิดใช้งานปุ่มลบ
        updateRemoveButtons();
        // เพิ่ม event listener ให้ปุ่มลบที่เพิ่มขึ้นใหม่
        newField.querySelector('.removeField').addEventListener('click', function() {
            newField.remove(); // ลบฟิลด์ออกจาก DOM
            updateRemoveButtons(); // อัปเดตปุ่มลบหลังจากลบ
        });
    }

    // ฟังก์ชันสำหรับอัปเดตสถานะปุ่มลบ
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.removeField');
        const toolFields = document.querySelectorAll('.toolField');
        // ถ้ามีมากกว่า 1 ฟิลด์ ให้เปิดใช้งานปุ่มลบ ถ้ามีแค่ 1 ปิดการใช้งานปุ่มลบ
        removeButtons.forEach(button => {
            if (toolFields.length > 1) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });
    }

    // เพิ่ม event listener ให้กับปุ่มลบของฟิลด์เริ่มต้น
    document.querySelectorAll('.removeField').forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.remove(); // ลบฟิลด์ออกจาก DOM
            updateRemoveButtons(); // อัปเดตปุ่มลบหลังจากลบ
        });
    });
</script>
</html>
<?php


// จัดการข้อมูลการเพิ่มเครื่องมือ
if (isset($_POST['save_tools'])) {
    $tool_names = $_POST['tool_name'];
    $tool_costs = $_POST['tool_cost'];
    // เตรียมการ insert ข้อมูลหลายรายการพร้อมกัน
    foreach ($tool_names as $index => $tool_name) {
        $tool_cost = $tool_costs[$index];
        // ตรวจสอบว่ามีชื่อเครื่องมือซ้ำหรือไม่
        $check_sql = "SELECT * FROM tools WHERE tool_name = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("s", $tool_name);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows > 0) {
            // ถ้าพบชื่อซ้ำ
            echo "<script>alert('มีชื่อเครื่องมือ $tool_name ในระบบแล้ว!'); window.location.href='tools_list.php';</script>";
        } else {
            // ถ้าไม่พบชื่อซ้ำ ทำการเพิ่มเครื่องมือ
            $stmt_insert = $conn->prepare("INSERT INTO tools (tool_name, cost) VALUES (?, ?)");
            $stmt_insert->bind_param("sd", $tool_name, $tool_cost);
            $stmt_insert->execute();
        }

        $stmt_check->close();
    }

    echo "<script>alert('เพิ่มเครื่องมือสำเร็จ!'); window.location.href='tools_list.php';</script>";
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