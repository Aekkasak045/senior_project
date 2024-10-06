<?php
require("inc_db.php");
include("user_function.php");
include("update_task_status.php");

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
    <?php require('../navbar/navbar.php') ?>

    <!-- ####################################################################### -->

<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <h5 class="modal-title" id="exampleModalLabel">Edit User Information</h5>
            <!-- Add enctype to support file uploads -->
            <form action="saveuser.php" method="POST" class="popup_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    
                    <!-- Display User Image -->
                    <div class="form-group text-center">
                        <img id="userImage" src="" alt="User Image" class="img-fluid">
                    </div>

                    <!-- Image Upload Field -->
                    <div class="form-group form__group mt-3 change_img">
                        <label class="form__label text_img">Change Profile Picture</label>
                        <input type="file" name="user_img" id="user_img" class="form-control form__field block_img" onchange="validateImageSize()">
                    </div>

                    <!-- Other Fields -->
                    <div class="form-group form__group mt-3 box1">
                        <input type="text" name="username" id="username" placeholder="Enter Username" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>Username</label>
                    </div>
                    <div class="form-group form__group box1">
                        <input type="text" name="password" id="password" placeholder="Enter Password" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>Password</label>
                    </div>
                    <div class="form-group form__group box1">
                        <input type="text" name="first_name" id="first_name" placeholder="Enter First Name" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>First Name</label>
                    </div>
                    <div class="form-group form__group box1">
                        <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>Last Name</label>
                    </div>
                    <div class="form-group form__group box1">
                        <input type="text" name="email" id="email" placeholder="Enter email" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>Email</label>
                    </div>
                    <div class="form-group form__group box1">
                        <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" style=" text-overflow: ellipsis; white-space: nowrap; " required>
                        <label>Phone Number</label>
                    </div>
                    <div class="box0">
                    <div class="form-group form__group box2">
                        <input type="date" name="bd" id="bd" class="form-control form__field" placeholder="Enter Birthday" required>
                        <label>Birthday</label>
                    </div>
                    <div class="form-group form__group box3">
                        <select name="role" id="role" class="boxrole" required>
                            <option value="admin">Admin</option>
                            <option value="mainten">Mainten</option>
                            <option value="user">User</option>
                        </select>
                        <label>Role</label>
                    </div>
                    </div>
                    <!-- Button to View Tasks - Hidden by default -->
                    <div id="viewTasksContainer" style="display: none;" class="mt-3 footer_view_task">
                        <button type="button" class="btn btn-info btn-sm view_task" onclick="viewTasks()">ดูงาน</button>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" name="updatedata" class="btn btn-primary edit">Save</button>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
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
                <!-- ########################### Search & Filter ########################### -->
                <div class="search_filter">
                    <div class="search">
                        <input class="search-input" type="text" name="search" id="search_text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <button onclick="openPop()" class="text-popup"><i class="fa-solid fa-filter"></i></button>
                    <div id="popupDialog">
                            <p class="filter">Filter</p>
                            <form action="" method="POST">
                                <div class="role-filter-box">
                                    <label class="role-font">ID : &nbsp;</label>
                                        <input class="idm" type="number" id="number" name="id_min" placeholder="Min ID">
                                        To
                                        <input class="idm" type="number" id="number" name="id_max" placeholder="Max ID">
                                    <br>
                                    <br>
                                    <label class="role-font">Option ID : </label>
                                    <div class="idc">
                                        <input type="radio" name="id" value="Lowest_to_Highest"> Lowest to Highest
                                        <br>
                                        <input type="radio" name="id" value="Highest_to_Lowest"> Highest to Lowest
                                        </div>
                                    <br>
                                    <label class="role-font">Birthday : 
                                    <br>
                                        <input class="bd" type="date" name="bd_min">
                                        To
                                        <input class="bd" type="date" name="bd_max">
                                    <br>
                                    <br>
                                    <label class="role-font">Role : </label>
                                    <div class="role-filter">
                                        <input type="radio" name="role" value="mainten"> Mainten
                                        <input type="radio" name="role" value="admin"> Admin
                                        <input type="radio" name="role" value="user"> User
                                    </div>
                                </div>
                                <br>
                            <button type="submit" name="used_filter" class="used-filter" id="filter_text">Used</button>
                            <label class="cencel-filter" onclick="openPop()">Close</label>
                            </form>
                        </div>
                        <?php if(isset($_POST['used_filter']))
                {   
                    $sql = filter_user();
                    $rs = mysqli_query($conn, $sql);
                }                    
                ?>
                </div>
                <!-- ####################################################################### -->
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
                                <tr class="table-lift editbtn" data-id="<?php echo $row['id']; ?>" onclick="openEditModal(this)">
                                    <?php echo role($row) ?>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["username"]; ?></td>
                                    <td><?php echo $row["password"]; ?></td>
                                    <td><?php echo $row["first_name"]; ?></td>
                                    <td><?php echo $row["last_name"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["phone"]; ?></td>
                                    <td><?php echo $row["bd"]; ?></td>
                                    <?php echo show_role($row) ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>



<!-- หน้าtaskListเมื่อกดดูงาน NEWWWWWW -->
<!-- Task List Modal -->
<div class="modal fade" id="taskListModal" tabindex="-1" role="dialog" aria-labelledby="taskListModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-width" role="document">
        <div class="modal-content">
            <!-- Header with custom styling -->
                <h5 class="modal-title" id="taskListModalLabel">Task List</h5>
            <!-- Body where tasks are displayed -->
                <div class="data_task">
                    <div class="modal-body model_task" id="taskListModalBody">
                </div>
                <!-- Content will be loaded via AJAX -->
            </div>
            <!-- Footer with action buttons (optional) -->
            <div class="footer_task">
                <button type="button" class="btn btn-secondary close_task" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script>
        // Function to open the edit modal and show the user's image
function openEditModal(element) {
    var userId = $(element).data('id');
    // Call the AJAX request to get the user's data including the image
    $.ajax({
        url: 'get_user_data.php', // URL of the PHP script to get user data
        method: 'GET',
        data: { id: userId },
        success: function(response) {
            var data = JSON.parse(response);
            $('#id').val(data.id);
            $('#username').val(data.username);
            $('#password').val(data.password);
            $('#first_name').val(data.first_name);
            $('#last_name').val(data.last_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#bd').val(data.bd);
            $('#role').val(data.role);
            // Set the image source to display the user's image
            $('#userImage').attr('src', 'data:image/jpeg;base64,' + data.user_img);

            // Show the "View Tasks" button if the user's role is "mainten"
            if (data.role === "mainten") {
                $('#viewTasksContainer').show();
                // Store userId in a global variable to use in the viewTasks function
                window.currentUserId = data.id;
            } else {
                $('#viewTasksContainer').hide();
            }

            $('#editmodal').modal('show'); // Show the modal
        }
    });
}

// Functionเรียกtaskในหน้าuser NEWWWWWW
function viewTasks() {
    if (window.currentUserId) {
        $.ajax({
            url: 'get_user_tasks.php',
            method: 'GET',
            data: { id: window.currentUserId },
            success: function(response) {
                $('#taskListModalBody').html(response);
                $('#taskListModal').modal('show'); 
            }
        });
    }
}

    </script>
<script>
    function validateImageSize() {
        const fileInput = document.getElementById('user_img');
        const file = fileInput.files[0];
        
        if (file.size > 2400000) {  // ขนาดไฟล์ 2.4MB = 2,400,000 bytes
            alert("The file is too large. Maximum size allowed is 2.4MB.");
            fileInput.value = '';  // รีเซ็ต input file ถ้าขนาดเกิน
        }
    }
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
