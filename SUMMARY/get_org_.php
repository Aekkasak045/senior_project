
<?php
$api_key = $_GET['api_key']; 
$valid_api_key = "HEEEEEEEEEEEEEEÉ"; 

if ($api_key === $valid_api_key) {

$servername = "localhost"; 
$username = "root"; 
$password = "kuse@fse2018"; 
$dbname = "smartlift"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

$id = $_GET['id'];
$org_id = $_GET['org_id'];

$sqlOrganizations = "SELECT org_name FROM organizations";
$resultOrganizations = $conn->query($sqlOrganizations);

$sqlLifts = "SELECT lift_name FROM lifts ";
$resultLifts = $conn->query($sqlLifts);

//Org_Array
if ($resultOrganizations->num_rows > 0) {
    $orgNames = array();

    while ($row = $resultOrganizations->fetch_assoc()) {
        $orgNames[] = $row['org_name'];
        
    }
    //COUNT_org
    $organization_count = count($orgNames);
    
    //Lifts_Array
    if ($resultLifts->num_rows > 0) {
        $liftNames = array();
    
        while ($row = $resultLifts->fetch_assoc()) {
            $liftNames[] = $row['lift_name'];
            
        }
        //COUNT_lifts
        $lifts_count = count($liftNames);
        $sqlOrganizationById = "SELECT id, org_name FROM organizations WHERE id = $id";
    $resultOrganizationById = $conn->query($sqlOrganizationById);
                 
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

            $combinedData = array(
                'organizations_count' => $organization_count,
                'organizations_all' => $orgNames,
                'lifts_count' => $lifts_count,
                'lifts_all' => $liftNames,
                'organization_by_id' => $organizationData,
                'lifts_orgid_count' => $lifts_orgid_count,
                'lifts_by_orgid' => $lifts
            );

            header('Content-Type: application/json');
            echo json_encode($combinedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            echo "ไม่พบข้อมูลลิฟท์สำหรับ org_id = $org_id";
        }
    } else {
        echo "ไม่พบข้อมูลองค์กรสำหรับ id = $id";
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
 

 