<?php
include ("inc_db.php");
include ("user_function.php");


$keyword = $_POST['search'];

$sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
        users.first_name AS engineer_first_name,
        users.last_name AS engineer_last_name, 
        task.org_name, task.building_name, task.lift_id, task.tools
        FROM task
        INNER JOIN users ON task.mainten_id = users.id
        WHERE tk_id LIKE '%$keyword%' OR
        tk_data LIKE '%$keyword%' OR
        users.first_name LIKE '%$keyword%' OR
        users.last_name LIKE '%$keyword%' OR
        org_name LIKE '%$keyword%' OR
        building_name LIKE '%$keyword%' OR
        lift_id LIKE '%$keyword%'
        OR IF('มอบหมาย' LIKE '%$keyword%',tk_status=1,tk_status=8)
        OR IF('กำลังเตรียมอุปกรณ์' LIKE '%$keyword%',tk_status=2,tk_status=8)
        OR IF('เตรียมอุปกรณ์เสร็จสิ้น' LIKE '%$keyword%',tk_status=3,tk_status=8)
        OR IF('กำลังดำเนินการ' LIKE '%$keyword%',tk_status=4,tk_status=8)
        OR IF('ดำเนินการเสร็จสิ้น' LIKE '%$keyword%',tk_status=5,tk_status=8)
        ORDER BY task.tk_id DESC";
$rs = mysqli_query($conn, $sql);
$data = '';

while ($row = mysqli_fetch_assoc($rs)) {
    $tools = json_decode($row["tools"], true);
    $toolsList = [];
    if (is_array($tools)) {
        foreach ($tools as $tool) {
            if (isset($tool['tool']) && isset($tool['quantity'])) {
                $toolsList[] = htmlspecialchars($tool['tool']) . ' (x' . htmlspecialchars($tool['quantity']) . ')';
            }
        }
    }
    $toolsOutput = !empty($toolsList) ? implode(", ", $toolsList) : 'No tools';

    $data .= "<tr class=\"table-lift\" onclick=\"\">"
                . "<td>" . $row["tk_id"] . "</td>"
                . show_task_status($row) 
                . "<td>" . $row["tk_data"] . "</td>"
                . "<td>" . $row["engineer_first_name"] . " " . $row["engineer_last_name"] . "</td>"
                . "<td>" . $row["org_name"] . "</td>"
                . "<td>" . $row["building_name"] . "</td>"
                . "<td>" . $row["lift_id"] . "</td>"
                . "<td>" . $toolsOutput . "</td>"
                . "<td class=\"parent-container\"><a id=\"edit-lift\" href=\"task_view.php?tk_id=" . $row["tk_id"] . "\" class=\"btn btn-success button-style\"> View </a></td>"
             . "</tr>";
}
echo $data;
?>