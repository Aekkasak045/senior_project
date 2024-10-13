<?php
include ("inc_db.php");
include ("user_function.php");


$keyword = $_POST['search'];

$sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,building.building_name,lifts.lift_name FROM report 
INNER JOIN users ON report.user_id = users.id 
INNER JOIN organizations ON report.org_id = organizations.id
INNER JOIN building ON organizations.id = building.id 
INNER JOIN lifts ON report.lift_id = lifts.id
WHERE rp_id LIKE '%$keyword%' OR
date_rp LIKE '%$keyword%' OR
first_name LIKE '%$keyword%' OR
org_name LIKE '%$keyword%' OR
building_name LIKE '%$keyword%' OR
lift_name LIKE '%$keyword%' OR
detail LIKE '%$keyword%'
ORDER BY rp_id DESC";
$rs = mysqli_query($conn, $sql);
$data = '';


while ($row = mysqli_fetch_assoc($rs)) {
    $data .= "<tr class=\"table-lift\" onclick=\"\">"
                . "<td>" . $row["rp_id"] . "</td>"
                . "<td>" . $row["date_rp"] . "</td>"
                . "<td>" . $row["first_name"] . "</td>"
                . "<td>" . $row["org_name"] . "</td>"
                . "<td>" . $row["building_name"] . "</td>"
                . "<td>" . $row["lift_name"] . "</td>"
                . "<td>" . $row["detail"] . "</td>"
                . "<td class=\"parent-container\"><a id=\"edit-lift\" href=\"Proceed_rp.php?rp_id=" . $row["rp_id"] . "\" class=\"btn btn-success button-style\"> Proceed </a></td>"
             . "</tr>";
}
echo $data;
?>