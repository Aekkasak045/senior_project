<?php

$api_key = $_GET['api_key']; 
$valid_api_key = "sum ma ry"; 

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

$sqlOrganizations = "SELECT org_name FROM organizations";
$resultOrganizations = $conn->query($sqlOrganizations);

$sqlLifts = "SELECT lift_name FROM lifts ";
$resultLifts = $conn->query($sqlLifts);

$sqlBuilding = "SELECT building_name FROM building";
$resultBuilding = $conn->query($sqlBuilding);

//Org_Array
if ($resultOrganizations->num_rows > 0) {
    $orgNames = array();

    while ($row = $resultOrganizations->fetch_assoc()) {
        $orgNames[] = $row['org_name'];
        
    }
    //COUNT
    $organization_count = count($orgNames);
    
    if ($resultLifts->num_rows > 0) {
        $liftNames = array();
    
        while ($row = $resultLifts->fetch_assoc()) {
            $liftNames[] = $row['lift_name'];
            
        }
        //COUNT
        $lifts_count = count($liftNames);

        if ($resultBuilding->num_rows > 0) {
            $building_name = array();
        
            while ($row = $resultBuilding->fetch_assoc()) {
                $building_name[] = $row['building_name'];
                
            }
            //COUNT
            $Building_count = count($building_name);
        
            $combinedData = array(
                'organizations_count' => $organization_count, //COUNT
                'organizations_all' => $orgNames,
                'Building_count' => $Building_count, //COUNT
                'Building_all' => $building_name,
                'lifts_count' => $lifts_count, //COUNT
                'lifts_all' => $liftNames,
               
            );

            header('Content-Type: application/json');
            echo json_encode($combinedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }else{
            echo "ไม่พบข้อมูลตึก";
        }   
    } else {
        echo "ไม่พบข้อมูลลิฟต์";
    }
} else {
    echo "ไม่พบข้อมูลองค์กร";
}

}


$conn->close();
?> 
 

 