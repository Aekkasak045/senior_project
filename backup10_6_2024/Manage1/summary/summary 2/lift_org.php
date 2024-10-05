<?php
require("inc_db.php");

mysqli_set_charset($cn, "utf8mb4");

if (isset($_GET["lift_id"])) {
    $lift_id = intval(mysqli_real_escape_string($cn, $_GET["lift_id"]));
} else {
    exit("Lift ID is required.");
}

$sql_org_id = "SELECT org_id FROM lifts WHERE id = $lift_id";
$rs_org_id = mysqli_query($cn, $sql_org_id);
$data_org_id = mysqli_fetch_assoc($rs_org_id);
$current_org_id = $data_org_id['org_id'];

$sql_count_lifts = "SELECT COUNT(*) as total_lifts_same_org FROM lifts WHERE org_id = $current_org_id";
$rs_count_lifts = mysqli_query($cn, $sql_count_lifts);
$data_count_lifts = mysqli_fetch_assoc($rs_count_lifts);
$total_lifts_same_org = $data_count_lifts['total_lifts_same_org'];

$sql_all_lifts = "SELECT L.lift_name, L.org_id, B.building_name, B.id as building_id";
$sql_all_lifts .= " FROM lifts L";
$sql_all_lifts .= " JOIN building B ON L.building_id = B.id";
$sql_all_lifts .= " WHERE L.id = $lift_id";
$rs_all_lifts = mysqli_query($cn, $sql_all_lifts);

$data = mysqli_fetch_assoc($rs_all_lifts);
if (!$data) {
    exit("No data found for given lift_id.");
}

$related_building_id = $data["building_id"];
$building_name = $data["building_name"];

$sql_all_lifts = "SELECT L.lift_name, L.org_id, B.building_name, B.id as building_id";
$sql_all_lifts .= " FROM lifts L";
$sql_all_lifts .= " JOIN building B ON L.building_id = B.id";
$sql_all_lifts .= " WHERE B.id = $related_building_id";

$rs_all_lifts = mysqli_query($cn, $sql_all_lifts);

if (!$rs_all_lifts) {
    printf("Error: %s\n", mysqli_error($cn));
    exit();
}
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
            <p>
                <?php echo $building_name; ?>
            </p>
            <span>
                <?php echo $total_lifts_same_org; ?> LIFTS
            </span>
            <div class="box_content">
                <?php
                while ($data_lifts = mysqli_fetch_assoc($rs_all_lifts)) {
                    echo '
    <a href="../../moniter-main_4/Status1/index.php?org_id=' . $data_lifts["org_id"] . '">
        <div class="box_data"> 
            <span>' . $data_lifts["lift_name"] . '</span>
            <span>VIEW</span>
        </div>
    </a>
  ';
                } ?>
            </div>
        </div>
    </main>
</body>
<!-- <script src="script.js"></script> -->

</html>