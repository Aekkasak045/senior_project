<?php
require("inc_db.php");
$report_id = $_GET["rp_id"];

// Ensure report ID is provided
if (!isset($report_id)) {
    die('Report ID not provided.');
}

// Fetch engineers
$engi = "SELECT id, first_name, last_name FROM users WHERE role='mainten'";
$result = $conn->query($engi);
$engineers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $engineers[] = $row;
    }
} else {
    echo "No engineers found";
}

// Fetch report details
$sql = "SELECT report.rp_id, report.detail, report.date_rp, report.user_id,
        users.username, users.first_name, users.last_name, users.email, users.phone, users.role,users.user_img,
        organizations.org_name, building.building_name, lifts.lift_name 
        FROM report 
        INNER JOIN users ON report.user_id = users.id 
        INNER JOIN organizations ON report.org_id = organizations.id
        INNER JOIN building ON report.building_id = building.id
        INNER JOIN lifts ON report.lift_id = lifts.id
        WHERE report.rp_id = $report_id";
$rs = mysqli_query($conn, $sql);

// Check if query execution was successful
if (!$rs) {
    die('Query Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($rs);

// Ensure the row is not empty
if (!$row) {
    die('No data found for the provided report ID.');
}

session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location:../login/login.php');
    exit(); // Add exit to stop the script after redirect
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:../login/login.php');
    exit(); // Add exit to stop the script after redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="proceed.css" />
    <title>Lift RMS</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php'); ?>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Create Task: <?php echo htmlspecialchars($row["rp_id"]); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- User Information -->
                    <div class="col-md-6 mb-4">
                        <form action="save_task.php" method="post">
                            <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row["rp_id"]); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($row["username"]); ?>">
                            <input type="hidden" name="org_name" value="<?php echo htmlspecialchars($row["org_name"]); ?>">
                            <input type="hidden" name="building_name" value="<?php echo htmlspecialchars($row["building_name"]); ?>">
                            <input type="hidden" name="lift_name" value="<?php echo htmlspecialchars($row["lift_name"]); ?>">
                            <div class="card mb-3">
                                <div class="card-body ">
                                    <h6 class="card-title">User Information</h6>
                                    <?php if (!empty($row["user_img"])): ?>
                                        <div class="text-center mb-3">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row["user_img"]); ?>" alt="User Image" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    <?php endif; ?>
                                    <p class="textinfo"><strong>Username:</strong> <?php echo htmlspecialchars($row["username"]); ?></p>
                                    <p class="textinfo"><strong>Name:</strong> <?php echo htmlspecialchars($row["first_name"]) . ' ' . htmlspecialchars($row["last_name"]); ?></p>
                                    <p class="textinfo"><strong>Phone:</strong> <?php echo htmlspecialchars($row["phone"]); ?></p>
                                    <p class="textinfo"><strong>Email:</strong> <?php echo htmlspecialchars($row["email"]); ?></p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <img src="https://cdn.icon-icons.com/icons2/1280/PNG/512/1497618988-16_85112.png" class="img-fluid p-3" alt="location-icon">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h6 class="card-title">Location</h6>
                                            <p class="textinfo"><strong>Organization:</strong> <?php echo htmlspecialchars($row["org_name"]); ?></p>
                                            <p class="textinfo"><strong>Building:</strong> <?php echo htmlspecialchars($row["building_name"]); ?></p>
                                            <p class="textinfo"><strong>Lift:</strong> <?php echo htmlspecialchars($row["lift_name"]); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Task Details -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6>Details</h6>
                                <div class="mb-3">
                                    <textarea name="detail" class="form-control" rows="4" placeholder="Enter details"><?php echo htmlspecialchars($row["detail"]); ?></textarea>
                                </div>

                                <h6>Tools Used</h6>
                                <div id="input-container" class="mb-3">
                                    <input type="text" name="tools[]" class="form-control mb-2" placeholder="Tool name">
                                </div>
                                <button class="btn btn-sm btn-secondary mb-3" type="button" onclick="addInput()">Add Tool</button>

                                <h6>Assign Engineer</h6>
                                <div class="mb-3">
                                    <select class="form-select" name="engineer_id" id="engineer" required>
                                        <?php foreach ($engineers as $engineer): ?>
                                            <option value="<?php echo htmlspecialchars($engineer['id']); ?>"><?php echo htmlspecialchars($engineer['first_name'] . ' ' . $engineer['last_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <input class="btn btn-primary" type="submit" name="edit" value="Create Task">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Report Button -->
                <form action="delete_report.php" method="post" onsubmit="return confirm('Are you sure you want to delete this report?');" class="text-center mt-3">
                    <input type="hidden" name="rp_id" value="<?php echo htmlspecialchars($row['rp_id']); ?>">
                    <button class="btn btn-danger" type="submit">Delete Report</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function addInput() {
        const container = document.getElementById("input-container");
        const newInput = document.createElement("input");
        newInput.type = "text";
        newInput.name = "tools[]";
        newInput.placeholder = "Tool name";
        newInput.className = "form-control mb-2";
        container.appendChild(newInput);
    }
</script>
<script src="scripts.js"></script>
