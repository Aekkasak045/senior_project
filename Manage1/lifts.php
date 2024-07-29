<?php
require ("inc_db.php");

if (isset($_GET["org_id"])) {
    $org_id = $_GET["org_id"];
} else {
    $org_id = $_GET["org_id"];
}

$sql = "SELECT L.id, O.org_name, L.lift_name, L.mac_address, L.max_level, L.floor_name";
$sql .= " FROM lifts L";
$sql .= " INNER JOIN organizations O ON L.org_id=O.id";
if ($org_id != 0) {
    $sql .= " WHERE L.org_id=$org_id";
}
$rs = mysqli_query($cn, $sql);
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
<html lang="en">

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
                    <li><a href="lifts.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                    <li><a href="summary/summary.php"> &nbsp;SUMMARY</a></li>
                    <li><a id="add-lift" href="add_lift.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a>
                        <li><?php if (isset($_SESSION['username'])): ?>
                            <p><a href="lifts.php?logout='1'" style="color: red;">Logout</a></p>
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
        <div class="main-content" id="content">
            <p>Infromations</p>
            <section class="table_body">
                <table class="table-lift">
                    <tr>
                        <th>ID</th>
                        <th>Org</th>
                        <th>Name</th>
                        <th>MAC Address</th>
                        <th>Max Level</th>
                        <th>Floor</th>
                        <th>Operation</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($rs)) {
                        ?>
                        <tr>
                            <td>
                                <?php print ($row["id"]); ?>
                            </td>
                            <td>
                                <?php print ($row["org_name"]); ?>
                            </td>
                            <td>
                                <?php print ($row["lift_name"]); ?>
                            </td>
                            <td>
                                <?php print ($row["mac_address"]); ?>
                            </td>
                            <td>
                                <?php print ($row["max_level"]); ?>
                            </td>
                            <td>
                                <?php print ($row["floor_name"]); ?>
                            </td>
                            <td><a id="edit-lift" href="edit_lift.php?lift_id=<?php print ($row["id"]); ?>"
                                    class="btn-submit">Edit</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

            </section>
        </div>
    </main>
    <script src="script.js"></script>
</body>

</html>

<script>
        function addInput() {
            const container = document.getElementById("input-container");
            const inputCount = container.getElementsByTagName("input").length;
            
            // Create a new input element
            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "devices[]"; // Name as an array
            
            // Append the new input element to the container
            container.appendChild(newInput);
        }
    </script>