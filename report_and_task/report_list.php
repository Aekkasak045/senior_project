<?php
require("inc_db.php");
include("user_function.php");
include("update_task_status.php");

$sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,building.building_name,lifts.lift_name 
FROM report 
INNER JOIN users ON report.user_id = users.id 
INNER JOIN organizations ON report.org_id = organizations.id 
INNER JOIN building ON organizations.id = building.id 
INNER JOIN lifts ON report.lift_id = lifts.id 
ORDER BY rp_id DESC;";
$rs = mysqli_query($conn, $sql);

$sql_problem = "SELECT pb_id, pb_name FROM problem";
$rs_problem = mysqli_query($conn, $sql_problem);


// ดึงข้อมูล Organization
$sql_org = "SELECT id as org_id, org_name FROM organizations";
$org_result = $conn->query($sql_org);
// ดึงข้อมูล building
$sql_building = "SELECT id as building_id, building_name FROM building";
$building_result = $conn->query($sql_building);
// ดึงข้อมูล lift
$sql_lift = "SELECT id as lift_id, lift_name FROM lifts";
$lift_result = $conn->query($sql_lift);
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
    <link rel="stylesheet" href="report.css" />
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
    <?php require('../navbar/navbar.php') ?>
    <div class="box-outer1">
        <div class="box-outer2">
            <section class="header_Table">
                <p class="User_information">Report information</p>

                <!-- ########################### Search & Filter ########################### -->
                <div class="search_filter">
                    <button onclick="openProblemPopup()" class="problemlistbt"><i class="fa-solid fa-list"></i> Problem List</button>
                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_report">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup"><i class="fa-solid fa-filter"></i></button>
                    <div id="popupDialog">
                        <p class="filter">Filter</p>
                        <form action="" method="POST">
                            <div class="role-filter-box">
                                <label class="role-font">ID : &nbsp;</label>
                                <input class="idm" type="number" id="number" name="id_min" placeholder="Min ID">
                                To
                                <input class="idm" type="number" id="number" name="id_max" placeholder="Max ID">
                                <br>
                                <br>
                                <label class="role-font">Option ID : </label>
                                <div class="idc">
                                    <input type="radio" name="id" value="Lowest_to_Highest"> Lowest to Highest
                                    <br>
                                    <input type="radio" name="id" value="Highest_to_Lowest"> Highest to Lowest
                                </div>
                                <label class="status-font">Position : </label>
                                <br>
                                <div class="row_position">
                                    <input type="radio" name="position" value="organizations" onclick="showOptions('organizations')"> Organizations
                                    <div id="organizations-options" style="display: none;">
                                        <select class="boxrole" id="org_name" name="org_name">
                                            <option value="">เลือก</option>
                                            <?php while ($org = $org_result->fetch_assoc()) { ?>
                                                <option value="<?php echo $org['org_name']; ?>">
                                                    <?php echo $org['org_id'] . " - " . $org['org_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row_position">
                                    <input type="radio" name="position" value="building" onclick="showOptions('building')"> Building
                                    <div id="building-options" style="display: none;">
                                        <select class="boxrole" id="building_name" name="building_name">
                                            <option value="">เลือก</option>
                                            <?php while ($building = $building_result->fetch_assoc()) { ?>
                                                <option value="<?php echo $building['building_name']; ?>">
                                                    <?php echo $building['building_id'] . " - " . $building['building_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row_position">
                                    <input type="radio" name="position" value="lifts" onclick="showOptions('lifts')"> Lifts
                                    <div id="lifts-options" style="display: none;">
                                        <select class="boxrole" id="lift_name" name="lift_name">
                                            <option value="">เลือก</option>
                                            <?php while ($lift = $lift_result->fetch_assoc()) { ?>
                                                <option value="<?php echo $lift['lift_name']; ?>">
                                                    <?php echo $lift['lift_id'] . " - " . $lift['lift_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <label class="role-font">Date :
                                    <br>
                                    <input class="bd" type="date" name="bd_min">
                                    To
                                    <input class="bd" type="date" name="bd_max">
                            </div>
                            <br>
                            <button type="submit" name="used_filter" class="used-filter" id="filter_text">Used</button>
                            <label class="cencel-filter" onclick="openPop()">Close</label>
                        </form>
                    </div>
                    <?php if (isset($_POST['used_filter'])) {
                        $sql = filter_report();
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
                            <!-- <th class="row-1 row-status"></th> -->
                            <th class="row-1 row-ID">ID</th>
                            <th class="row-2 row-Date">Date</th>
                            <th class="row-3 row-Username">User</th>
                            <th class="row-4 row-Organization">Organization</th>
                            <th class="row-4 row-building">Building</th>
                            <th class="row-5 row-Lift">Lift</th>
                            <th class="row-6 row-Detail">Detail</th>
                            <th class="row-7 row-Action">Action</th>
                        </tr>
                    </thead>
                    <div class="box-row">
                        <tbody id="showdata">
                            <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                                <tr class="table-lift">
                                    <td><?php print($row["rp_id"]); ?></td>
                                    <td><?php print($row["date_rp"]); ?></td>
                                    <td><?php print($row["first_name"]); ?></td>
                                    <td><?php print($row["org_name"]); ?></td>
                                    <td><?php print($row["building_name"]); ?></td>
                                    <td><?php print($row["lift_name"]); ?></td>
                                    <td><?php print($row["detail"]); ?></td>
                                    <td class="parent-container"><a id="edit-lift" href="Proceed_rp.php?rp_id=<?php print($row["rp_id"]); ?>" class="btn btn-success button-style"> Proceed </a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
    <!-- Popup สำหรับแสดงรายการปัญหา -->
    <div id="problemPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeProblemPopup()">&times;</span>
            <h2 class="popup-header">Problem List</h2>
            <!-- ฟอร์มสำหรับเพิ่มปัญหาใหม่ -->
            <form id="addProblemForm" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="new_problem" id="new_problem" placeholder="Enter new problem" required>
                    <button class="btn btn-success" type="button" id="addProblemBtn">+</button>
                </div>
            </form>
            <ul class="list-group mb-3">
                <?php while ($row_problem = mysqli_fetch_assoc($rs_problem)) { ?>
                    <li class="list-group-item"><?php echo $row_problem['pb_name']; ?></li>
                <?php } ?>
            </ul>


        </div>
    </div>
</body>
<script src="scripts.js"></script>
<script>
    function showOptions(option) {
        // ซ่อนตัวเลือกทั้งหมดก่อน
        document.getElementById("organizations-options").style.display = "none";
        document.getElementById("building-options").style.display = "none";
        document.getElementById("lifts-options").style.display = "none";

        // แสดงตัวเลือกที่เลือกเท่านั้น
        if (option === "organizations") {
            document.getElementById("organizations-options").style.display = "block";
        } else if (option === "building") {
            document.getElementById("building-options").style.display = "block";
        } else if (option === "lifts") {
            document.getElementById("lifts-options").style.display = "block";
        }
    }
</script>

</html>

<?php
if (isset($_POST['add_problem'])) {
    $new_problem = mysqli_real_escape_string($conn, $_POST['new_problem']);

    // ตรวจสอบว่าปัญหานั้นมีอยู่แล้วหรือไม่
    $check_problem = "SELECT * FROM problem WHERE pb_name = '$new_problem'";
    $result_check = mysqli_query($conn, $check_problem);

    if (mysqli_num_rows($result_check) == 0) {
        // เพิ่มรายการปัญหาใหม่
        $sql_add_problem = "INSERT INTO problem (pb_name) VALUES ('$new_problem')";
        mysqli_query($conn, $sql_add_problem);
        echo "<script>alert('New problem added successfully');</script>";
        echo "<script>window.location.reload();</script>";
    } else {
    }
}
?>