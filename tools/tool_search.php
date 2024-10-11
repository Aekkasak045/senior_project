<?php
include ("inc_db.php");
include ("user_function.php");


$keyword = $_POST['search'];

$sql = "SELECT * FROM tools";
$rs = mysqli_query($conn, $sql);
$data = '';


while ($row = mysqli_fetch_assoc($rs)) {
    $data .= "<tr class=\"table-lift\" onclick=\"\">"
                . "<td>" . $row["tool_id"] . "</td>"
                . "<td>" . $row["tool_name"] . "</td>"
                . "<td>" . $row["cost"] . "</td>"
                . "<td class=\"parent-container\"><a id=\"edit-lift\" href=\"Proceed_rp.php?rp_id=" . $row["rp_id"] . "\" class=\"btn btn-success button-style\"> Proceed </a></td>"
             . "</tr>";
}
echo $data;
?>