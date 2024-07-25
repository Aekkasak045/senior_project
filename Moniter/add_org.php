<?php
require("inc_db.php");

?>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lift RMS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
  
<header>
        <div class="navbar">
            <div class="logo"><img src="assets\images\logo company\icon_yellow.svg" alt=""></a></div>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
            <p>Asia Schneider</p>
            <ul class="links">
                <li><a href="index2.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                <!-- <li><a href="add_org.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li> -->
                <!-- <li><a href="../moniter-main_4/Status1/index.php?org_id=<?php print($row["id"]); ?>"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;STATUS</a></li> -->
            </ul>
            <div class="wrap">
                <form action="" autocomplete="on">
                    <input class="search" id="search" name="search" type="text" placeholder="Search...">
                    <input class="search" id="search_submit" value="Rechercher" type="submit">
                </form>
            </div>
            <div><i class="fa-solid fa-user"></i></div>

        </div>

        <!-- <div class="dropdown_menu">
            <li><a href="lifts.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
            <li><a href="add_lift.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li> -->

            <!-- <div class="wrap">
                <form action="" autocomplete="on">
                    <input class="search" id="search" name="search" type="text" placeholder="Search...">
                    <input class="search" id="search_submit" value="Rechercher" type="submit">
                </form>
            </div> -->
        <!-- </div> -->
    </header>

<main>

<div class="main-content">
            <p>Organization</p>
            <form action="submit_add_org.php" method="post">
            <div class="form-add">

            <input class="orgs-id" type="hidden" name="id" 
                value="<?php print($org["id"]);?>"><br>

            <label for="">Name<span>*</span></label><br>
            <input type="text" name="org_name" size="30" 
                value="<?php print($org["org_name"]);?>"><br>



            <input class="btn-submit" type="submit">
            </div>
            <!-- <tr>
                        <td>Organization:</td>
                        <td>
                            <select name="org_id">
                                <?php
                                while ($row = mysqli_fetch_assoc($rs_org)) {
                                ?>
                                <option value="<?php print($row["id"]); ?>">
                                    <?php print($row["org_name"]); ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr> -->

    <!-- <label for="">Name<span>*</span></label><br> -->
    <!-- <input type="text" name="org_name" size="30" 
    value="<?php print($org["org_name"]);?>"><br> -->

    <!-- <input class="btn-submit" type="submit">
            </div> -->




<!-- <style>
    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
}
</style> -->


<!-- <form action="submit_add_org.php" method="post"> -->
<!-- <table>
    <tr>
        <td>Organization:</td> -->
        <!-- <td>
            <input type="text" name="org_name" size="30" value="<?php print($org["org_name"]);?>">
        </td>
    </tr> -->
    <!-- <tr><td colspan="2"><input type="submit"></td></tr> -->
<!-- </table>
</form> -->

</main>
</body>
</html>
