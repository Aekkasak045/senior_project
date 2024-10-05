<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require("inc_db.php");

mysqli_set_charset($cn, "utf8mb4");
if (isset($_GET["org_id"])) {
    $org_id = $_GET["org_id"];
} else {
    $org_id = $_GET["org_id"];
}

// $sql = "SELECT L.id, O.org_name, B.building_name, L.lift_name, L.mac_address, L.max_level, L.floor_name";
// $sql .= " FROM lifts L";
// $sql .= " INNER JOIN organizations O ON L.org_id=O.id";
// $sql .= " LEFT JOIN building B ON L.org_id=B.org_id"; // สมมติว่าเราเชื่อมตาราง building ด้วย org_id
// if ($org_id != 0) {
//     $sql .= " WHERE L.org_id=$org_id";
// }
$sql = "SELECT B.building_name, COUNT(L.id) as lift_count";
$sql .= " FROM lifts L";
$sql .= " LEFT JOIN building B ON L.org_id=B.org_id";
if ($org_id != 0) {
    $sql .= " WHERE L.org_id=$org_id";
}
$sql .= " GROUP BY B.building_name";


$rs = mysqli_query($cn, $sql);
$lift = mysqli_fetch_assoc($rs);
echo "
<pre>";
print_r($lift);
echo "</pre>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lift RMS</title>
    <link rel="stylesheet" href="style1.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <main class="content">
        <div class="name_page">
            <p>SUMMARY</p>
            <span>DETAIL AND ORGANIZATION BUILD ELVATOR</span>
            <div class="box_content" id="box-content">
                <?php
                $rs = mysqli_query($cn, $sql);
                while ($data = mysqli_fetch_assoc($rs)) {
                    echo "<div class='building-item'>";
                    echo "<h3>Building: " . $data["building_name"] . "</h3>";
                    echo "<p>Total Lifts: " . $data["lift_count"] . "</p>";
                    echo "</div>"; // End building-item
                }
                ?>
            </div>
        </div>
    </main>
</body>
<script src="test.js"></script>

</html>