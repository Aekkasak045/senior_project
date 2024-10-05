<?php
require("inc_db.php");
mysqli_set_charset($cn, "utf8mb4");

if (isset($_GET["org_id"])) {
    $org_id = intval($_GET["org_id"]);
} else {
    $org_id = 0;
}

// Query for total lifts
$lifts_sql = "SELECT COUNT(*) as total_lifts FROM lifts";
$lifts_result = mysqli_query($cn, $lifts_sql);
$lifts_data = mysqli_fetch_assoc($lifts_result);
$total_lifts = $lifts_data['total_lifts'];

$sql = "SELECT B.building_name, L.lift_name, L.org_id FROM lifts L LEFT JOIN building B ON L.org_id=B.org_id";
if ($org_id != 0) {
    $sql .= " WHERE L.org_id=?";
}
$sql .= " GROUP BY B.building_name, L.lift_name";

$stmt = mysqli_prepare($cn, $sql);
if ($org_id != 0) {
    mysqli_stmt_bind_param($stmt, "i", $org_id);
}
mysqli_stmt_execute($stmt);
$rs = mysqli_stmt_get_result($stmt);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lift RMS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="navbar-2">
                <div class="logo"><img src="assets\images\logo company\icon_yellow.svg" alt=""></a></div>
                <div class="toggle_btn">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <p>Asia Schneider</p>
                <ul class="links">
                    <li><a href="summary.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                    <div class="dropdown">
                        <button class="dropbtn">LIFTS &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="../lifts.php">HOME LIFT</a>
                            <a href="../add_lift.php">ADD_LIFT</a>
                            <a href="../edit_lift.php">EDIT_LIFT</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="dropbtn">ORGANIZATION &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="../orgs.php">HOME ORGANIZATION</a>
                            <a href="../add_org.php">ADD_ORGANIZATION</a>
                            <a href="../edit_org.php">EDIT_ORGANIZATION</a>
                        </div>
                </ul>
                <div class="wrap">
                    <form action="" autocomplete="on">
                        <input class="search" id="search" name="search" type="text" placeholder="Search...">
                        <input class="search" id="search_submit" value="Rechercher" type="submit">
                    </form>
                </div>
                <div><i class="fa-solid fa-user"></i></div>
            </div>
        </div>
    </header>
    <main class="content">
        <div class="name_page">
            <p>LIFTS</p>
            <span>
                <?php echo $total_lifts; ?> LIFTS
            </span>
            <div class="box_content">
                <?php

                $rs = mysqli_query($cn, $sql);
                while ($data = mysqli_fetch_assoc($rs)) {
                    echo '
      <a href="../../moniter-main_4/Status1/index.php?org_id=' . $data["org_id"] . '">
            <div class="box_data"> 
                <span>' . $data["lift_name"] . '</span>
                <span>VIEW</span>
            </div>
        </a>
    ';
                }
                ?>

            </div>
        </div>
    </main>
</body>
<script src="script.js"></script>
<script>
    <?php
    $sql = "SELECT id FROM lifts WHERE org_id=?";
    $stmt = mysqli_prepare($cn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $org_id);
    mysqli_stmt_execute($stmt);
    $rs2 = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($rs2)) {
        ?>
        setInterval(function () {
            getData(<?php echo $row["id"]; ?>);
        }, 1000);
        <?php
    }
    ?>
</script>


</html>