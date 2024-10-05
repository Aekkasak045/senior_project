<?php
require("inc_db.php");

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

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lift RMS</title>
    <link rel="stylesheet" href="style1.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="navbar-2">
                <div class="logo"><img src="assets\images\logo company\icon_yellow.svg" alt=""></a></div>
                <div class="toggle_btn">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <ul class="links">
                    <li><a href="orgs.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                    <li><a href="summary/summary.php"> &nbsp;SUMMARY</a></li>
                    <li><a href="add_org.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li>
                    <li><?php if (isset($_SESSION['username'])): ?>
                            <p><a href="add_org.php?logout='1'" style="color: red;">Logout</a></p>
                        <?php endif ?></li>
                    <!-- <div class="dropdown">
                        <button class="dropbtn">ORGANIZATION &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="../orgs.php">HOME ORGANIZATION</a>
                            <a href="../add_org.php">ADD_ORGANIZATION</a>
                            <a href="../edit_org.php">EDIT_ORGANIZATION</a>
                        </div>
                    </div> -->
                </ul>
                <div class="wrap">
                    <form action="" autocomplete="on">
                        <input class="search" id="search" name="search" type="text" placeholder="Search...">
                        <input class="search" id="search_submit" value="Rechercher" type="submit">
                    </form>
                </div>
                <div><i class="fa-solid fa-user"></i></div>
            </div>
        </div>
    </header>

    <main>

        <div class="main-content">

            <form action="submit_add_org.php" method="post" id="form_head">
                <div class="form-edit-add">
                    <input class="orgs-id" type="hidden" name="id" value="<?php print($org["id"]); ?>"><br>

                    <label for="">Name<span class="span1">*</span></label><br>
                    <input class="input-form" id="add_org" type="text" name="org_name" size="30"
                        value="<?php print($org["org_name"]); ?>"><br>

                    <div class="btn"> <input class="btn-submit" type="submit"> </div>
                </div>
    </main>
    <script src="script.js"></script>
</body>

</html>