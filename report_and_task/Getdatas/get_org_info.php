<?php
require("inc_db.php");

if (isset($_GET['org_id'])) {
    $org_id = $_GET['org_id'];

    // ดึง Organization ตาม org_id
    $sql_org = "SELECT org_name FROM organizations WHERE id = ?";
    $stmt_org = $conn->prepare($sql_org);
    $stmt_org->bind_param("i", $org_id);
    $stmt_org->execute();
    $result_org = $stmt_org->get_result();
    $org_data = $result_org->fetch_assoc();

    // ดึง Building และ Lift
    $sql_building = "SELECT id as building_id, building_name FROM building WHERE org_id = ?";
    $stmt_building = $conn->prepare($sql_building);
    $stmt_building->bind_param("i", $org_id);
    $stmt_building->execute();
    $result_building = $stmt_building->get_result();

    $buildings = [];
    while ($row = $result_building->fetch_assoc()) {
        $buildings[] = $row;
    }

    $sql_lift = "SELECT id as lift_id, lift_name FROM lifts WHERE org_id = ?";
    $stmt_lift = $conn->prepare($sql_lift);
    $stmt_lift->bind_param("i", $org_id);
    $stmt_lift->execute();
    $result_lift = $stmt_lift->get_result();

    $lifts = [];
    while ($row = $result_lift->fetch_assoc()) {
        $lifts[] = $row;
    }

    // ส่ง org_name พร้อมข้อมูล buildings และ lifts กลับไป
    echo json_encode(['org_name' => $org_data['org_name'], 'buildings' => $buildings, 'lifts' => $lifts]);
}

?>
