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


    <!-- ####################################################################### -->
    <!-- EDIT POP UP FORM ( Bootstrap MODAL) -->
    <div class="modal fade row" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog col" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title textpop" id="exampleModalLabel"> Edit User information </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="saveuser.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="textpop"> Username </label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> Password </label>
                            <input type="text" name="password" id="password" class="form-control"
                                placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> First Name </label>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> Last Name </label>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> Phone Number </label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                placeholder="Enter Phone Number">
                        </div>
                        <div class="form-group">
                            <label class="textpop"> Birthday </label>
                            <input type="date" name="bd" id="bd" class="form-control" placeholder="Enter Birthday">
                        </div>
                        <!-- <div class="form-group">
                            <label> Role </label>
                            <input type="text" name="role" id="role" class="form-control" placeholder="Enter Role">
                        </div> -->
                        <div class="form-group">
                        <label class="textpop"> Role </label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin
                                </option>
                                <option value="mainten">Mainten
                                </option>
                                <option value="user" >User
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ####################################################################### -->

    <div class="box-outer1">
        <div class="box-outer2">
            <section class="header_Table">
                <p class="User_information">User Information</p>
                <div class="search_filter">
                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup "><i class="fa-solid fa-filter"></i></button>
                    <!-- <div id="popupDialog">
                        <p>Filter</p>
                        <form action="user_filter" method="post"></form>
                        <div class="role-filter-box">
                            <p class="role-font">ID : <input type="number" name="id_nim">:<input type="number"
                                    name="id_max"></p>
                            <p class="role-font">Option ID : </p><input type="radio" name="id_ltoh" value="id_ltoh">
                            Lowest to Highest <input type="radio" name="id_htol" value="id_htol"> Highest to Lowest
                            <p class="role-font">Birthday : <input type="date" name="hbd_min" value="hbd_min">:<input
                                    type="date" name="hbd_max" value="hbd_max"></p>
                            <p class="role-font">Option Birthday : </p><input type="radio" name="hbd_ltoh"
                                value="hbd_ltoh"> Lowest to Highest <input type="radio" name="hbd_htol"
                                value="hbd_htol"> Highest to Lowest
                            <p class="role-font">Role</p>
                            <div class="role-filter">
                                <label id="filter-style">Mainten</label><input type="checkbox" name="mainten"
                                    value="mainten">
                                <label id="filter-style">Admin</label><input type="checkbox" name="admin" value="admin">
                                <label id="filter-style">User</label><input type="checkbox" name="user" value="user">
                            </div>
                        </div>
                        </form>
                        <button class="use-filter" onclick="()">
                            Use
                        </button>
                        <button class="cencel-filter " onclick="openPop()">
                            Close
                        </button>
                    </div> -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery. dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="scripts.js"></script>