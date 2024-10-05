<?php
require("inc_db.php");

mysqli_set_charset($cn, "utf8mb4");
if (isset($_GET["org_id"])) {
    $org_id = $_GET["org_id"];
} else {
    $org_id = $_GET["org_id"];
}

// Query สำหรับนับจำนวนตึกทั้งหมด
$buildings_sql = "SELECT COUNT(*) as total_buildings FROM building";
$buildings_result = mysqli_query($cn, $buildings_sql);
$buildings_data = mysqli_fetch_assoc($buildings_result);
$total_buildings = $buildings_data['total_buildings'];

// $sql = "SELECT B.building_name, COUNT(L.id) as lift_count";
// $sql .= " FROM lifts L";
// $sql .= " LEFT JOIN building B ON L.org_id=B.org_id";
// if ($org_id != 0) {
//     $sql .= " WHERE L.org_id=$org_id";
// }
// $sql .= " GROUP BY B.building_name";

// $rs = mysqli_query($cn, $sql);
$sql = "SELECT B.building_name, B.org_id, COUNT(L.id) as lift_count"; // Add B.org_id
$sql .= " FROM lifts L";
$sql .= " LEFT JOIN building B ON L.org_id=B.org_id";
if ($org_id != 0) {
    $sql .= " WHERE L.org_id=$org_id";
}
$sql .= " GROUP BY B.building_name, B.org_id"; // Group by org_id also

$rs = mysqli_query($cn, $sql);

$lift = mysqli_fetch_assoc($rs);
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
            <p>BUILDINGS</p>
            <span>
                <?php echo $total_buildings; ?> BUILDINGS
            </span>
            <div class="box_content">
                <?php
                $rs = mysqli_query($cn, $sql);
                while ($data = mysqli_fetch_assoc($rs)) {
                    echo '
         <a href="build_org.php?org_id=' . $data["org_id"] . '">
            <div class="box_data"> 
                <span>' . $data["building_name"] . '</span>
                <span>' . $data["lift_count"] . ' ELEVATOR</span>
            </div>
        </a>
      ';
                }

                ?>
            </div>
        </div>
    </main>
</body>
<!-- <script src="script.js"></script> -->

</html>