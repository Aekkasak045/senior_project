<?php
require ("inc_db.php");
include ("user_function.php");

$sql = "SELECT * FROM users";
$rs = mysqli_query($conn, $sql);
?>

<!-- ####################################################################### -->
<!-- เช็ค session ว่ามีหรือเปล่า -->
<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location:../login/login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:../login/login.php');
}
?>
<!-- ####################################################################### -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="User.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Lift RMS</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body class="background1">
    <!-- navbar -->
    <?php require ('../navbar/navbar.php') ?>


    <div class="box-outer1">
        <div class="box-outer2">
            <section class="header_Table">
                <p class="User_information">Report information</p>  
                <div class="search_filter">
                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup "><i class="fa-solid fa-filter"></i></button>
                </div>
            </section>
            <div class="sec1">
                <table class="table1" id="table-data">
                    <thead>
                        <tr class="table-lift">
                            <th class="row-1 row-status"></th>
                            <th class="row-2 row-ID">ID</th>
                            <th class="row-3 row-Username">Username</th>
                            <th class="row-3 row-Username">Password</th>
                            <th class="row-4 row-Name">Firstname</th>
                            <th class="row-4 row-Name">Lastname</th>
                            <th class="row-5 row-Email">Email</th>
                            <th class="row-8 row-phone">Phone</th>
                            <th class="row-6 row-Birthday">Birthday</th>
                            <th class="row-7 row-Role">Role</th>
                        </tr>
                    </thead>
                    <div class="box-row">
                        <tbody id="showdata">
                            <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                                <tr class="table-lift   editbtn" onclick="">
                                    <?php echo role($row) ?>
                                    <td><?php print ($row["id"]); ?></td>
                                    <td><?php print ($row["username"]); ?></td>
                                    <td><?php print ($row["password"]); ?></td>
                                    <td><?php print ($row["first_name"]); ?></td>
                                    <td><?php print ($row["last_name"]); ?></td>
                                    <td><?php print ($row["email"]); ?></td>
                                    <td><?php print ($row["phone"]); ?></td>
                                    <td><?php print ($row["bd"]); ?></td>
                                    <?php echo show_role($row) ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<!-- script สำหรับการ search-input -->
<script>
    $(document).ready(function () {
        $('#search_text').on("keyup", function () {
            var search_text = $(this).val();
            $.ajax({
                method: 'POST',
                url: 'user_search.php',
                data: { search: search_text },
                success: function (response) {
                    $("#showdata").html(response);
                }
            });
        });
    });
</script>

