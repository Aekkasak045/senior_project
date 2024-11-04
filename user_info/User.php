<?php
require("inc_db.php");
$sql = "SELECT * FROM users ORDER BY id ASC";
$rs = mysqli_query($conn, $sql);
// if ($rs->num_rows > 0)
// $row = $rs->fetch_assoc();
?>

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
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="User.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>Dashboard</title>
</head>

<body class="background1">
    <span>

    </span>
    <?php
    include('../sidebar/sidebar.php'); ?>

    <!-- ####################################################################### -->
    <!-- EDIT POP UP FORM ( Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit User information </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="saveuser.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label> Username </label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label> Password </label>
                            <input type="text" name="password" id="password" class="form-control"
                                placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label> First Name </label>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label> Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label> Phone Number </label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                placeholder="Enter Phone Number">
                        </div>

                        <div class="form-group">
                            <label> Birthday </label>
                            <input type="text" name="bd" id="bd" class="form-control" placeholder="Enter Birthday">
                        </div>
                        <div class="form-group">
                            <label> Role </label>
                            <input type="text" name="role" id="role" class="form-control" placeholder="Enter Role">
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
                <form action="" method="post">
                    <div class="search_filter">
                        <div class="search">
                            <input class="search-input" type="search" name="keyword">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <i class="fa-solid fa-filter"></i>
                    </div>
                </form>
            </section>
            <div class="sec1">
                <table class="table1">
                    <tr class="table-lift">
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>FirstName</th>
                        <th>Lastnamae</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Birthday</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    <div class="box-row">
                        <?php while ($row = mysqli_fetch_assoc($rs)) { ?>
                            <tr class="table-lift">
                                <td><?php print($row["id"]); ?></td>
                                <td><?php print($row["username"]); ?></td>
                                <td><?php print($row["password"]); ?></td>
                                <td><?php print($row["first_name"]); ?></td>
                                <td><?php print($row["last_name"]); ?></td>
                                <td><?php print($row["email"]); ?></td>
                                <td><?php print($row["phone"]); ?></td>
                                <td><?php print($row["bd"]); ?></td>
                                <td><?php if ($row["role"] == "mainten")
                                        print("Mainten");
                                    elseif ($row["role"] == "admin")
                                        print("Admin");
                                    else
                                        print("User"); ?></td>
                                <td>
                                    <!-- <a id="edit" href="edit_user.php?id=<?php print($row["id"]); ?>"
                                        class="editbtn">Edit</a> -->
                                    <button type="button" class="btn btn-success editbtn"> EDIT </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </div>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery. dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {

        $('.editbtn').on('click', function() {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#id').val(data[0]);
            $('#username').val(data[1]);
            $('#password').val(data[2]);
            $('#first_name').val(data[3]);
            $('#last_name').val(data[4]);
            $('#email').val(data[5]);
            $('#phone').val(data[6]);
            $('#bd').val(data[7]);
            $('#role').val(data[8]);
        });
    });
</script>