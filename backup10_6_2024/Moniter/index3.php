<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Lift RMS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
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
                <!-- <li><a href=""></i> &nbsp;ORGANIZATION</a></li> -->
                <!-- <li><a href=""></i> &nbsp;BUILDING</a></li>
                <li><a href=""> &nbsp;ELEVATOR</a></li> -->
                <div class="dropdown">
                    <button class="dropbtn">MENU
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#">ADD_LIFT</a>
                        <a href="add_org.php">ADD_ORG</a>
                        <a href="#">EDIT_LIFT</a>
                        <a href="edit_org.php">EDIT_ORG</a>
                    </div>
                </div>

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
            <li><a href=""><i class="fa-solid fa-house"></i> &nbsp;HOME</a></li>
            <li><a href=""><i class="fa-solid fa-file-circle-plus"></i> &nbsp;ADD</a></li> -->

        <!-- <div class="wrap">
            <form action="" autocomplete="on">
                <input class="search" id="search" name="search" type="text" placeholder="Search...">
                <input class="search" id="search_submit" value="Rechercher" type="submit">
            </form>
        </div> -->
        </div>
    </header>


    <main>
        <div class="main-content" id="content">
            <p>ORGANIZATION</p>
            <p>12 ORGANIZATION 30 BUILDING</p>


            <div class="container">
                <div class="card-container">
                    <div class="row">
                        <div class="col-lg-4" id="col-4">
                            <!-- <div class="card"> -->
                            <!-- <div class="border"></div>
                                <div class="content"></div> -->
                            <!-- <div class="set"> -->
                            <!-- 12
                                    <p>ORGANIZATION</p> -->

                            <!-- </div>
                           </div> -->
                        </div>
                        <!-- <div class="col-lg-4">
                           <div class="card">   
                                <div class="border"></div>
                                <div class="content"></div>
                                <div class="set">
                                    10
                                    <p>BUILDING</p>
                              
                                </div>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="card">
                                <div class="border"></div>
                                <div class="content"></div>
                                <div class="set">
                                    120
                                    <p>ELEVATOR</p> -->

                        <!-- </div> -->
                        <!-- </div>
                        </div> -->
                    </div>
                </div>
            </div>


            <!-- <div class="fa-box" id="mydata"></div> -->

        </div>
    </main>



</body>
<script src=script_org.js></script>

</html>


