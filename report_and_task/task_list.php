<?php
require("inc_db.php");
include("user_function.php");
include("update_task_status.php");

$sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
        users.first_name AS engineer_first_name,
        users.last_name AS engineer_last_name, 
        task.org_name, task.building_name, task.lift_id, task.tools
        FROM task
        INNER JOIN users ON task.mainten_id = users.id
        ORDER BY task.tk_id DESC";
$rs = mysqli_query($conn, $sql);
?>

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
                                        <input type="radio" name="status" value="1"> มอบหาย
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
                            <th class="row-2 row-Name">Status</th>
                            <th class="row-3 row-Name">Task Detail</th>
                            <th class="row-4 row-Name">Engineer</th>
                            <th class="row-5 row-Name">Organization</th>
                            <th class="row-6 row-Name">Building</th>
                            <th class="row-7 row-Name">Lift</th>
                            <th class="row-8 row-Username">Tools</th>
                            <th class="row-9 row-Action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="showdata">
                        <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                            <tr class="table-lift">
                                <td><?php echo htmlspecialchars($row['tk_id']); ?></td>
                                <?php echo show_task_status($row); ?>
                                <td><?php echo htmlspecialchars($row['tk_data']); ?></td>
                                <td><?php echo htmlspecialchars($row['engineer_first_name'] . ' ' . $row['engineer_last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['org_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['building_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['lift_id']); ?></td>
                                <td>
                                    <?php
                                    $tools = json_decode($row['tools'], true);
                                    if (is_array($tools)) {
                                        $toolsList = [];
                                        foreach ($tools as $tool) {
                                            // Assuming each $tool is an associative array with 'tool' and 'quantity' keys
                                            if (isset($tool['tool']) && isset($tool['quantity'])) {
                                                $toolsList[] = htmlspecialchars($tool['tool']) . ' (x' . htmlspecialchars($tool['quantity']) . ')';
                                            }
                                        }
                                        // Display all tools, each followed by its quantity
                                        echo implode(", ", $toolsList);
                                    } else {
                                        echo 'No tools';
                                    }
                                    ?>
                                </td>
                                <td class="parent-container"><a id="edit-lift" href="task_view.php?tk_id=<?php echo htmlspecialchars($row["tk_id"]); ?>" class="btn btn-success button-style">View</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="scripts.js"></script>
</html>
