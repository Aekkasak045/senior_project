<?php
require ("inc_db.php");
include ("user_function.php");
include("update_task_status.php");

$sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name FROM report 
INNER JOIN users ON report.user_id = users.id 
INNER JOIN organizations ON report.org_id = organizations.id
INNER JOIN lifts ON report.lift_id = lifts.id
ORDER BY rp_id ASC;";
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
    <?php require ('../navbar/navbar.php') ?>


    <div class="box-outer1">
        <div class="box-outer2">
            <section class="header_Table">
                <p class="User_information">Report information</p>  
                <!-- <div class="search_filter">
                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup "><i class="fa-solid fa-filter"></i></button>
                </div> -->
            </section>
            <div class="sec1">
                <table class="table1" id="table-data">
                    <thead>
                        <tr class="table-lift">
                            <!-- <th class="row-1 row-status"></th> -->
                            <th class="row-1 row-ID">ID</th>
                            <th class="row-2 row-Username">Date</th>
                            <th class="row-3 row-Username">User</th>
                            <th class="row-4 row-Name">Organization</th>
                            <th class="row-5 row-Name">Lift</th>
                            <th class="row-6 row-Username">Detail</th>
                            <th class="row-7 row-Action">Action</th>
                        </tr>
                    </thead>
                    <div class="box-row">
                        <tbody id="showdata">
                            <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                                <tr class="table-lift" onclick="">
                                    <td><?php print ($row["rp_id"]); ?></td>
                                    <td><?php print ($row["date_rp"]); ?></td>
                                    <td><?php print ($row["first_name"]); ?></td>
                                    <td><?php print ($row["org_name"]); ?></td>
                                    <td><?php print ($row["lift_name"]); ?></td>
                                    <td><?php print ($row["detail"]); ?></td>
                                    <td><a id="edit-lift" href="Proceed_rp.php?rp_id=<?php print ($row["rp_id"]); ?>" class="btn btn-success"> Proceed </a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<script src="scripts.js"></script>

