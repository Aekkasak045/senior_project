<?php
include ("inc_db.php");
// include ("user_function.php");


$keyword = $_POST['search'];

$sql = "SELECT * FROM tools WHERE tool_id LIKE '%$keyword%' OR tool_name LIKE '%$keyword%' OR cost LIKE '%$keyword%' ORDER BY tool_id ASC";
$rs = mysqli_query($conn, $sql);
$data = '';


while ($row = mysqli_fetch_assoc($rs)) {
    $data .= "<tr class=\"table-lift\">"
                . "<td class=\"parent-container1\">" . $row["tool_id"] . "</td>"
                . "<td>" . $row["tool_name"] . "</td>"
                . "<td>" . $row["cost"] . "</td>"
                . "<td class=\"parent-container\"><a href=\"#\" class=\"btn btn-success editTool\" onclick=\"editTool('"
                . $row['tool_id'] . "', '" . $row['tool_name'] . "', '" . $row['cost'] . "')\" data-bs-toggle=\"modal\" data-bs-target=\"#editModal\">แก้ไข</a> "
                . "<a href=\"?delete_tool_id=" . htmlspecialchars($row["tool_id"]) . "\" class=\"btn btn-danger editTool\">ลบ</a></td>"
             . "</tr>";
}
echo $data;

?>