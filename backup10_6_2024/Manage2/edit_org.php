<?php
require("inc_db.php");
$org_id=$_GET["org_id"];


$sql = "SELECT * FROM organizations WHERE id = $org_id";

$rs=mysqli_query($cn, $sql);
$org = mysqli_fetch_assoc($rs);
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lift RMS</title>
  <!-- <link rel="stylesheet" href="style.css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="stylesheet" href="style.css" />
  <!-- <script src="script.js" defer></script> -->
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
                <li><a href="orgs.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                <li><a href="add_org.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li>
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

        <div class="dropdown_menu">
            <li><a href="lifts.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
            <li><a href="add_lift.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li>

            <div class="wrap">
                <form action="" autocomplete="on">
                    <input class="search" id="search" name="search" type="text" placeholder="Search...">
                    <input class="search" id="search_submit" value="Rechercher" type="submit">
                </form>
            </div>
        </div>
    </header>



    <main>
    <div class="main-content" id="content">
            <p>Organization</p>
            <form action="submit_edit_org.php" method="post">

            <div class="form-edit">
            <!-- <label for="">Orgs ID</label> -->
            <input class="orgs-id" type="hidden" name="id" 
            value="<?php print($org["id"]);?>"><br>
            
            <label for="">Name<span>*</span></label><br>
            <input type="text" name="org_name" size="30" 
                value="<?php print($org["org_name"]);?>"><br>

            <!-- <p>โปรดตรวจสอบความเรียบร้อยของข้อมูล</p> -->
            <input class="btn-submit" type="submit">
            </div>


<!-- <style>
    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
}

body {
    width: 100%;
    min-height: 95vh;
    background: rgb(74, 153, 103);
    background: linear-gradient(0deg, rgba(74, 153, 103, 0.8799894957983193) 100%, rgba(40, 161, 35, 0.8799894957983193) 100%);
}
</style> -->

<!-- <form action="submit_edit_org.php" method="post"> -->
<!-- <table>
    <tr> -->
        <!-- <td>Organization:</td> -->
        <!-- <td>
            <input type="hidden" name="id" value="<?php print($org["id"]);?>">
            <input type="text" name="org_name" size="30" value="<?php print($org["org_name"]);?>">
        </td>
    </tr>
    <tr><td colspan="2"><input type="submit"></td></tr>
</table> -->
<!-- </form> -->

    </main>
    <script src="script.js" defer></script> 
</body>
</html>
