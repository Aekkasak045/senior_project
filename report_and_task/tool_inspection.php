<?php
require("inc_db.php");

// Fetch all tools from the task table (assuming tools are stored in a JSON format)
$sql = "SELECT task.tk_id, task.tools, users.first_name, users.last_name
        FROM task
        INNER JOIN users ON task.mainten_id = users.id";
$rs = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool Inspection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>

<body class="background1">
    <!-- Navbar -->
    <?php require('../navbar/navbar.php'); ?>

    <div class="container mt-4">
        <h2 class="mb-4">Tool Inspection</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Task ID</th>
                        <th scope="col">Engineer</th>
                        <th scope="col">Tool Name</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($rs)) {
                        $tools = json_decode($row['tools'], true);
                        if (is_array($tools)) {
                            foreach ($tools as $tool) {
                                // Display each tool with its details
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['tk_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($tool['tool']) . "</td>";
                                echo "<td>" . htmlspecialchars($tool['quantity']) . "</td>";
                                echo "</tr>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
