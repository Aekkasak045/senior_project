<?php
require("inc_db.php");
$lift_id = $_GET["lift_id"];

$sql = "SELECT * FROM organizations";
$rs_org = mysqli_query($cn, $sql);
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
            <div class="logo"><img src="assets\images\logo company\icon_yellow.svg" alt=""></a></div>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
            <p>Asia Schneider</p>
            <ul class="links">
                <li><a id="home-lift" href="lifts.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
                <li><a id="add-lift" href="add_lift.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li>
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
            <li><a id="home-lift" href="lifts.php"><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
            <li><a id="add-lift" href="add_lift.php"><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li>

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
            <p>Infromations</p>
            <div class="group-1">
                <div class="text-wrapper-1">Organization</div>
                <div class="text-wrapper-2">Lift Name</div>
                <div class="text-wrapper-3">Mac Address</div>
                <div class="text-wrapper-4">Max Level</div>
                <div class="text-wrapper-5">Floor Name</div>
            </div>
            <div class="rectangle">
                <div class="circle" id="circle1">✓</div>
                <div class="circle" id="circle2">✓</div>
                <div class="circle" id="circle3">✓</div>
                <div class="circle" id="circle4">✓</div>
                <div class="circle" id="circle5">✓</div>
                <!-- <div class="group-wrapper">
                    <div class="group-2">
                        <div class="rectangle-1"></div>
                        <div class="rectangle-2"></div>
                    </div>
                </div>
                <div class="overlap-1">
                    <div class="group-2">
                        <div class="rectangle-1"></div>
                        <div class="rectangle-2"></div>
                    </div>
                </div>
                <div class="overlap-2">
                    <div class="group-3">
                        <div class="rectangle-1"></div>
                        <div class="rectangle-2"></div>
                    </div>
                </div>
                <div class="overlap-3">
                    <div class="group-2">
                        <div class="rectangle-1"></div>
                        <div class="rectangle-2"></div>
                    </div>
                </div>
                <div class="overlap-4">
                    <div class="group-3">
                        <div class="rectangle-1"></div>
                        <div class="rectangle-2"></div>
                    </div>
                </div> -->
                <div class="text-wrapper-6">STEP 1</div>
                <div class="text-wrapper-7">STEP 2</div>
                <div class="text-wrapper-8">STEP 3</div>
                <div class="text-wrapper-9">STEP 4</div>
                <div class="text-wrapper-10">STEP 5</div>
                <div class="rectangle-3"></div>
                <div class="rectangle-4"></div>
                <div class="rectangle-5"></div>
                <div class="rectangle-6"></div>
            </div>
            <form action="submit_add_lift.php" method="post">
                <div class="form">
                    <label for="select">Organization <span>*</span></label><br>
                    <select name="org_id" id="select">
                        <?php
                        while ($row = mysqli_fetch_assoc($rs_org)) {
                            ?>
                        <option value="<?php print($row["id"]); ?>">
                            <?php print($row["org_name"]); ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select><br>

                    <label for="input2">Lift Name<span>*</span></label><br>
                    <input id="input2" class="input-form" type="text" name="lift_name" size="20"><br>

                    <label for="input3">MAC Address<span>*</span></label><br>
                    <input id="input3" class="input-form" type="text" name="mac_address" size="20">
                    <br>

                    <label for="input4">Max Level<span>*</span></label><br>
                    <input id="input4" class="input-form" type="text" name="max_level" size="4"
                        oninput="createInputFields()"><br>

                    <label for="input5">Floor Name<span>*</span></label><br>
                    <p>กรุณากรอกให้ครบตามจำนวนช่อง</p>
                    <div id="input5" class="floor_name"></div>
                    <!-- <input class="input-form" type="text" name="floor_name" size="40"><br> -->

                    <p class="text-check">โปรดตรวจสอบความเรียบร้อยของข้อมูล</p>
                    <div class="btn"><input class="btn-submit" type="submit"></div>

                </div>
            </form>
        </div>
    </main>
    <script src="script.js"></script>
</body>