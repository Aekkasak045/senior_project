<?php
require("inc_db.php");
$id = $_GET["id"];
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
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
    <!-- <?php
            include('../Manage1/summary/nav_bar.php');
            ?> -->
    <?php
    include('../sidebar/sidebar.php'); ?>
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
                <div class="box1">
                    <form action="saveuser.php" method="post" class="editpage">
                        <input type="hidden" name="id" value="<?php print($row["id"]) ?>">
                        Username:<input class="editbox" type="text" name="username"
                            value="<?php print($row["username"]); ?>"><br>
                        First Name:<input class="editbox" type="text" name="first_name"
                            value="<?php print($row["first_name"]); ?>"><br>
                        Last Name:<input class="editbox" type="text" name="last_name"
                            value="<?php print($row["last_name"]); ?>"><br>
                        Email:<input class="editbox" type="text" name="email"
                            value="<?php print($row["email"]); ?>"><br>
                        Phone Number:<input class="editbox" type="text" name="phone"
                            value="<?php print($row["phone"]); ?>"><br>
                        Role:<select name="role" class="editbox">
                            <option class="editbox" value="admin" <?php if ($row["role"] == "admin")
                                                                        print("selected"); ?>>Admin</option>
                            <option class="editbox" value="mainten" <?php if ($row["role"] == "mainten")
                                                                        print("selected"); ?>>Mainten
                            </option>
                            <option class="editbox" value="user" <?php if ($row["role"] == "user")
                                                                        print("selected"); ?>>User</option>
                        </select><br>
                        <input type="submit" value="SUBMIT" class="submitbtn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>