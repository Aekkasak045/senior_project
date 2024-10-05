<?php
$api_key = $_GET['api_key']; 
$valid_api_key = "Test api webs"; 

if ($api_key === $valid_api_key) {

$servername = "localhost"; 
$username = "root"; 
$password = "kuse@fse2018"; 
$dbname = "smartlift"; 
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

$id = $_GET['id'];
$org_id = $_GET['org_id'];
$building_name =$_GET['building_name'];

    $sqlOrganizationById = "SELECT id, org_name FROM organizations WHERE id = $id";
    $resultOrganizationById = $conn->query($sqlOrganizationById);
    $organizationData_count = count($resultOrganizationById);

    if ($resultOrganizationById->num_rows > 0) {
        $organizationData = $resultOrganizationById->fetch_assoc();
       

        $sqlLifts = "SELECT org_id,lift_name FROM lifts WHERE org_id = $org_id";
        $resultLifts = $conn->query($sqlLifts);

        if ($resultLifts->num_rows > 0) {
            $lifts = array();
            while ($row = $resultLifts->fetch_assoc()) {
                $lifts[] = $row['lift_name'];
            }
            $lifts_orgid_count = count($lifts);

            $sqlBuildingById = "SELECT building_name FROM building WHERE org_id = $org_id";
            $resultBuildingById = $conn->query($sqlBuildingById);
            if ($resultBuildingById->num_rows > 0) {
                $sqlBuildingById = $resultBuildingById->fetch_assoc();


            $combinedData = array(
                'organization_byid_count' => $organizationData_count,
                'organization_by_id' => $organizationData,
                'building' => $sqlBuildingById,
                'lifts_orgid_count' => $lifts_orgid_count,
                'lifts_by_orgid' => $lifts
                
            );


            header('Content-Type: application/json');
            echo json_encode($combinedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        else{
            echo "ไม่พบข้อมูลองค์กรสำหรับ Buildings = $org_id";
        }
        } else {
            echo "ไม่พบข้อมูลลิฟท์สำหรับ lifts = $org_id";
        }
    } else {
        echo "ไม่พบข้อมูลองค์กรสำหรับ Organizations = $id";
    }
        
}


$conn->close();
?> 
 

 