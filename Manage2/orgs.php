<?php
require("inc_db.php");

$sql = "SELECT * FROM organizations";
$rs = mysqli_query($cn, $sql);
?>
<!Doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lift RMS</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
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
    <section class="table_body">
      <table class="table-orgs">
        <tr>
          <th>Org Name</th>
          <th>Operation</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($rs)) {
        ?>

          <tr>
            <td><?php print($row["org_name"]); ?></td>
            <td><a href="edit_org.php?org_id=<?php print($row["id"]); ?>">Edit</a>
              <a href="../moniter-main_4/Status1/index.php?org_id=<?php print($row["id"]); ?>">Status</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
    </section>
  
  </div>
  </main>
  <script src="script.js" defer></script>
</body>
</html>



  <!-- <li>
  <a href="add_org.php">Add</a>
</li> -->
    <!-- </main> -->



<!-- <main>
    <section class="parent">
      <section class="child1">
        <header class="head">
          <h2><?php print($org["org_name"]); ?></h2>
        </header>

        <div class="container"></div>
  </main> -->