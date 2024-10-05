<?php
require("inc.php");

$lift_id = $_GET["lift_id"];
// $data = $redis->lRange('Lift-' . str_pad($lift_id, 4, "0", STR_PAD_LEFT), 0, 9);
$array = array();
$array["org_name"] = $data[0];
$array["lift_name"] = $data[1];
$array["building_name"] = $data[3];
$date = new DateTime($array["last_update"]);
$date2 = new DateTime();
$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();
$array['connection_status'] = $diffInSeconds > 30 ? "Offline" : "Online";
echo json_encode($array, JSON_FORCE_OBJECT);