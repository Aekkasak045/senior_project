<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lift RMS</title>
    <!-- <link rel="stylesheet" href="<?php echo __DIR__."/nav_style.css"?>" /> -->
    <style>
        <?php include(__DIR__ ."/nav_style.css"); ?>
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    
    <div class="my-navbar ">
        <div class="my-navbar-2">
                <div class="logo"><img src="..\navbar\assets\images\logo company\icon_yellow.svg" alt=""></a></div>
                
                <ul class="my-links">
                    <li class="my-home"><a href="..\Manage1\summary\summary.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                    <div class="my-dropdown">
                        <button class="dropbtn">LIFTS &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="my-dropdown-content">
                            <a href="..\Manage1\lifts.php">HOME LIFT</a>
                            <a href="..\Manage1\add_lift.php">ADD_LIFT</a>
                            <a href="..\Manage1\edit_lift.php">EDIT_LIFT</a>
                        </div>
                    </div>
                    <div class="my-dropdown">
                        <button class="dropbtn">ORGANIZATION &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="my-dropdown-content">
                            <a href="..\Manage1\orgs.php">HOME ORGANIZATION</a>
                            <a href="..\Manage1\add_org.php">ADD_ORGANIZATION</a>
                            <a href="..\Manage1\edit_org.php">EDIT_ORGANIZATION</a>
                        </div>
                    </div>
                    <div class="my-dropdown">
                        <button class="dropbtn">Dashboard &nbsp;
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="my-dropdown-content">
                            <a href="../user_info/user_information.php">USER INFO</a>
                            <a href="../report_and_task/report_list.php">REPORT</a>
                            <a href="../report_and_task/task_list.php">TASK</a>
                            <a href="../tools/tools_list.php">Tools</a>
                        </div>
                    </div>
                </ul>
                <div class="wrap">
                    <form action="" autocomplete="on">
                        <input class="search" id="search" name="search" type="text" placeholder="Search...">
                        <input class="search" id="search_submit" value="Rechercher" type="submit">
                    </form>
                </div>
                
                <div class="logout">
                    <?php if (isset($_SESSION['username'])): ?>
                        <p><a href="?logout='1'" style="color: red;">Logout</a></p>
                    <?php endif ?>
                </div>
                <div class="logout"><i class="fa-solid fa-user"></i></div>

                <div class="toggle_btn">
                    <i class="fa-solid fa-bars"></i>
                </div>
        </div>
        <div class="menu-navbar">
            <div class="dropbtn">
                    <a href="..\Manage1\summary\summary.php" class="drophome"><i class="fa-solid fa-house"></i>&nbsp;HOME</a>
            </div>
            <div class="menu-dropdown">
                    <button class="dropbtn">LIFTS &nbsp;
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="menu-dropdown-content">
                            <a href="..\Manage1\lifts.php">HOME LIFT</a>
                            <a href="..\Manage1\add_lift.php">ADD_LIFT</a>
                            <a href="..\Manage1\edit_lift.php">EDIT_LIFT</a>
                    </div>
            </div>
            <div class="menu-dropdown">
                    <button class="dropbtn">ORGANIZATION &nbsp;
                            <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="menu-dropdown-content">
                            <a href="..\Manage1\orgs.php">HOME ORGANIZATION</a>
                            <a href="..\Manage1\add_org.php">ADD_ORGANIZATION</a>
                            <a href="..\Manage1\edit_org.php">EDIT_ORGANIZATION</a>
                    </div>
            </div>
            <div class="menu-dropdown">
                    <button class="dropbtn">Dashboard &nbsp;
                            <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="menu-dropdown-content">
                            <a href="../user_info/user_information.php">USER INFO</a>
                            <a href="../report_and_task/report_list.php">REPORT</a>
                            <a href="../report_and_task/task_list.php">TASK</a>
                            <a href="../tools/tools_list.php">Tools</a>
                    </div>
            </div>
            <div class="menu-logout">
                    <?php if (isset($_SESSION['username'])): ?>
                        <p><a href="?logout='1'" style="color: red; font-weight: bold;font-size: calc(9px + 0.5vw);">Logout</a></p>
                    <?php endif ?>
            </div>
            <div class="menu-logout">
                    <i class="fa-solid fa-user"></i>
            </div>
        </div>
    </div>
</body>
<script>
    const toggleBtn=document.querySelector('.toggle_btn')
    const toggleBtnIcon=document.querySelector('.toggle_btn i')
    const dropDownMenu=document.querySelector('.menu-navbar')

    toggleBtn.onclick=function(){
        dropDownMenu.classList.toggle('open')
        const isOpen=dropDownMenu.classList.contains('open')
        toggleBtnIcon.classList=isOpen
            ? 'fa-solid fa-xmark'
            : 'fa-solid fa-bars'
    }
</script>
<script src="script.js"></script>

</html>