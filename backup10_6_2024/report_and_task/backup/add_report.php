<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Report</h2>
        <form action="save_report.php" method="post">
            <div class="mb-3">
                <label for="date_rp" class="form-label">Date</label>
                <input type="date" class="form-control" id="date_rp" name="date_rp" required>
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="mb-3">
                <label for="org_id" class="form-label">Organization ID</label>
                <input type="text" class="form-control" id="org_id" name="org_id" required>
            </div>
            <div class="mb-3">
                <label for="building_id" class="form-label">Building ID</label>
                <input type="text" class="form-control" id="building_id" name="building_id" required>
            </div>
            <div class="mb-3">
                <label for="lift_id" class="form-label">Lift ID</label>
                <input type="text" class="form-control" id="lift_id" name="lift_id" required>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Task</button>
        </form>
    </div>
</body>
</html>
