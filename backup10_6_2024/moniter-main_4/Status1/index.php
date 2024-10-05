<?php
$host = "localhost";
$user = "smartlift";
$passwd = "Smart123!";
$db = "smartlift";

$org_id = $_GET["org_id"];
$cn = mysqli_connect($host, $user, $passwd, $db);
$sql = "SELECT * FROM organizations WHERE id=$org_id";
$rs1 = mysqli_query($cn, $sql);
$org = mysqli_fetch_assoc($rs1);
$sql = "SELECT * FROM lifts L WHERE org_id=$org_id";
$rs2 = mysqli_query($cn, $sql);
?>
<!DOCTYPE html>
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
    <link rel="manifest" href="site.webmanifest">
</head>

<body>
    <!-- ***** Header Area Start ***** -->
    <header>
        <div class="navbar">
            <div class="logo"><img src="assets/images/logo.svg" alt=""></a></div>
            <div class="wrap">
                <form action="" autocomplete="on">
                    <input class="search" id="search" name="search" type="text" placeholder="Search...">
                    <input class="search" id="search_submit" value="Rechercher" type="submit">
                </form>
                <div><i class="fa-solid fa-user" style="line-height: 3.5rem;"></i></div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <main>
        <section class="parent">
            <div class="container">
                <?php
                while ($row = mysqli_fetch_assoc($rs2)) {
                    ?>
                <div class="flex-item item-1">
                    <div class="flex-item item-2">
                        <div class="flex-item item-3">
                            <h4>
                                <?php print($row["lift_name"]); ?>
                                <!-- <span>
                                        <h5>Max Level
                                            <?php print($row["max_level"]); ?>
                                        </h5>
                                    </span> -->
                            </h4>
                            <div class="status">
                                <div class="icon">
                                    <!-- <p class="icon1" id="ic_door_<?php print($row["id"]); ?>"></p> -->
                                    <img src=" assets\images\sliding-door.png" alt="sliding-door">
                                    <h5 id="door_<?php print($row["id"]); ?>"></h5>
                                </div>

                                <div class="icon">
                                    <img src="assets\images\mode.png" alt="mode">
                                    <h5 id="mode_<?php print($row["id"]); ?>"></h5>
                                </div>

                                <div class="icon">
                                    <img src="assets\images\conn.png" alt="connection">
                                    <h5 id="connection_<?php print($row["id"]); ?>"></h5>
                                </div>
                            </div>
                        </div>

                        <table class="car_level" id="carLevel_<?php print($row["id"]); ?>">
                            <?php
                                $maxLevel = $row["max_level"];
                                $floorName = explode(",", $row["floor_name"]);
                                $numRows = ceil($maxLevel / 4);
                                $numCols = ceil($maxLevel / $numRows);
                                $counter = 1;
                                for ($i = 0; $i < $numRows; $i++) {
                                    print("\t\t\t<tr>\n");
                                    for ($j = 0; $j < $numCols; $j++) {
                                        if ($counter <= count($floorName)) {
                                            print("\t\t\t\t<td id=\"car_" . $row["id"] . "_$counter\">" . $floorName[$counter - 1] . " </td>\n");
                                            $counter++;
                                        } else {
                                            break;
                                        }
                                    }
                                    print("\t\t\t</tr>\n");
                                }
                                ?>
                        </table>
                    </div>
                    <br>
                    <div class="lift_simulation">

                        <div class="column_arrow" id="colsArrow_<?php print($row["id"]); ?>">
                            <?php for ($i = $maxLevel - 1; $i >= 0; $i--) {
                                    if ($i == $maxLevel - 1) {
                                        print("<div class=\"arrow-box\" id=\"arrowBox_" . $row["id"] . "_" . ($i + 1) . "\">
                    <div class=\"arrow\" id=\"downArrow_" . $row["id"] . "_" . ($i + 1) . "\">&#9662;</div></div>");
                                    } elseif ($i == 0) {
                                        print("<div class=\"arrow-box\" id=\"arrowBox_" . $row["id"] . "_" . ($i + 1) . "\">
                    <div class=\"arrow\" id=\"upArrow_" . $row["id"] . "_" . ($i + 1) . "\">&#9652;</div></div>");
                                    } else {
                                        print("<div class=\"arrow-box\" id=\"arrowBox_" . $row["id"] . "_" . ($i + 1) . "\">
                    <div class=\"arrow\" id=\"upArrow_" . $row["id"] . "_" . ($i + 1) . "\">&#9652;</div>
                    <div class=\"arrow\" id=\"downArrow_" . $row["id"] . "_" . ($i + 1) . "\">&#9662;</div></div>");

                                    }
                                }
                                ?>
                        </div>

                        <div class="column_circle" id="cir_<?php print($row["id"]); ?>">
                            <div id="lift_<?php print($row["id"]); ?>">
                                <div class="line" id="line_<?php print($row["id"]); ?>"></div>
                                <?php
                                    for ($i = $maxLevel - 1; $i >= 0; $i--) {
                                        print(" <div class=\"out_circle\">
                    <div id=\"circle_" . $row["id"] . "_" . ($i + 1) . "\"></div></div>");
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class=" column_liftFloor" id="colsLiftFloor_<?php print($row["id"]); ?>">
                            <table id="lift_<?php print($row["id"]); ?>">
                                <?php
                                    for ($i = $maxLevel - 1; $i >= 0; $i--) {
                                        print("<div class=\"num_liftFloor\" id=\"num_" . $row["id"] . "_" . ($i + 1) . "\">" . $floorName[$i] . "</div>");
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>
    </main>
</body>
<script src="script.js">
</script>
<script>
<?php
    $sql = "SELECT * FROM lifts WHERE org_id=$org_id";
    $rs2 = mysqli_query($cn, $sql);
    while ($row = mysqli_fetch_assoc($rs2)) {
        ?> setInterval(function() {
    getData(<?php print($row["id"]); ?>);
}, 1000);
<?php
    }
    ?>
</script>

</html>