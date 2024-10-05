<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moniter</title>
    <link rel="stylesheet" href="stlye.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="script.js" defer></script>
</head>

<body>

    animation: pageReset 1s infinite;

    <!-- KUSE  -->
    <?php
    $get_data = file_get_contents("http://52.221.67.113/smartlift/get_status_redis.php?lift_id=1");
    $status = json_decode($get_data,);

    $org_name = $status->org_name;
    $lift_name = $status->lift_name;
    $max_level = $status->max_level;

    ?>

    <!-- SKTC -->
    <?php
    $get_data = file_get_contents("http://52.221.67.113/smartlift/get_status_redis.php?lift_id=2");
    $status = json_decode($get_data,);

    $org_name2 = $status->org_name;
    $lift_name2 = $status->lift_name;
    $max_level2 = $status->max_level;

    ?>


    <!-- KUSE -->
    <?php
    $url = 'http://52.221.67.113/smartlift/get_status_redis.php?lift_id=1';
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if ($data === null) {
        echo 'Failed to fetch API data';
        exit;
    }
    $value = $data['lift_state'];
    $max_level = $data['max_level'];

    ?>

    <!-- SKTC-->
    <?php
    $url = 'http://52.221.67.113/smartlift/get_status_redis.php?lift_id=2';
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if ($data === null) {
        echo 'Failed to fetch API data';
        exit;
    }
    $value2 = $data['lift_state'];
    $max_level2 = $data['max_level'];

    ?>

    <!-- ***** Header Area Start ***** -->
    <header class="header">

        <i class="fa-solid fa-bars OpenBtn"></i>
        <img class="logo" src="assets/images/icon_company.png" alt="" />
        <form action="" method="get" class="search-bar">
            <input type="text" placeholder="Search..." name="q" />
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <ul class="menu">
            <i class="fa fa-times CloseBtn"></i>
            <li><a href="#" class="active">Home</a></li>
            <li><a href="#">Organization</a></li>
            <li><a href="#">Static</a></li>
        </ul>

        <i class="fa fa-search search-icon" id="searchIcon"></i>
        <div class="search-box">
            <!-- <i class="fa fa-search search-icon"></i> -->
            <input type="text" placeholder="Search..." name="q">
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>

        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <main>
        <section class="parent">
            <section class="child1">
                <header class="head">
                    <h2><?php echo $org_name; ?></h2>
                    <ul class="work-status">
                        <li class="content1">on 6</li>
                        <li class="content2">off 0</li>
                        <li class="content3">all 9</li>
                    </ul>
                </header>

                <div class="container">
                    <div class="flex-item item-1">
                        <h4><?php echo $lift_name; ?></h4>
                        <table class="tb_kusktc">
                            <tr>
                                <td <?php if ($value === '010900000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '110900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '210900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>1</h1>
                                </td>
                                <td <?php if ($value === '020900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '020901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '120900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '220900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>2</h1>
                                </td>

                                <td <?php if ($value === '030900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '030901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '130900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '230900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>3</h1>
                                </td>

                                <td <?php if ($value === '040900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '040901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '140900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '240900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>4</h1>
                                </td>

                                <td <?php if ($value === '050900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '050901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '150900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '250900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>5</h1>
                                </td>
                            </tr>
                            <tr>
                                <td <?php if ($value === '060900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '060901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '160900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '260900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>6</h1>
                                </td>
                                <td <?php if ($value === '070900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '070901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '170900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '270900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>7</h1>
                                </td>
                                <td <?php if ($value === '080900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '080901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '180900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '280900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>8</h1>
                                </td>
                                <td <?php if ($value === '090900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '090901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '190900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '290900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>9</h1>
                                </td>
                                <td <?php if ($value === '010910000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '010911000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '110910000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '210910000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>10</h1>
                                </td>

                            </tr>
                            <tr>
                                <td <?php if ($value === '011900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '011901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '111900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '211900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>11</h1>
                                </td>
                                <td <?php if ($value === '012900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '012901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '112900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '212900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>12</h1>
                                </td>
                                <td <?php if ($value === '013900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '013901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '113900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '213900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>13</h1>
                                </td>
                                <td <?php if ($value === '014900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '014901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '114900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '214900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>14</h1>
                                </td>
                                <td <?php if ($value === '015900000000') {
                                        echo ' class="animatedElement" ';
                                    } elseif ($value === '015901000000') {
                                        echo ' class="animatedElement"';
                                    } elseif ($value === '115900000000') {
                                        echo ' class="animatedElement1"';
                                    } elseif ($value === '215900000000') {
                                        echo ' class="animatedElement2"';
                                    }
                                    ?>>
                                    <h1>15</h1>
                                </td>
                            </tr>
                        </table>

                        <div class="lift_simulation">
                            <!-- <div class="status_icons2">
                                <span><i class="fa-solid fa-caret-up"></i></span>
                                <span><i class="fa-solid fa-caret-down"></i></span>
                            </div> -->

                            <!-- <div class="column_arrow_KU">
                                <p><span class="column_arrow_1_KU" <?php if ($value === '015901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span></p>
                                <p><span class="column_arrow_1_KU" <?php if ($value === '014900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class=" column_arrow_1_KU" <?php if ($value === '014901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '013900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '013901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '012900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '012901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '011900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '011901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '010910000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '010911000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '090900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '090901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '080900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '080901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '070900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '070901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '060900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '060901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '050900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '050901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '040900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '040901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '030900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '030901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class=" column_arrow_1_KU" <?php if ($value === '020900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span>
                                    <span class="column_arrow_1_KU" <?php if ($value === '020901000000') {
                                                                        echo ' class="animatedElement_arrow_down" ';
                                                                    }
                                                                    ?>>&#8681;</span>
                                </p>
                                <p><span class="column_arrow1_KU" <?php if ($value === '010900000000') {
                                                                        echo ' class="animatedElement_arrow_up" ';
                                                                    }
                                                                    ?>>&#8679;</span></p>
                            </div> -->

                            <!-- <div class="column_arrow_KU">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_KU"><br></div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8679;</div>
                                    </tr>
                                </table>

                            </div>
                            <div class="column_arrow_KU_1">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU"><br></div>
                                    </tr>
                                </table>

                            </div> -->
                            <div class="column_arrow_KU">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_KU"><br></div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '014900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU"><?php if ($value === '013900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '012900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '011900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '010900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '090900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '080900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '070900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '060900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '050900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '040900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '030900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '020900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '010900000000') {
                                                                            echo ' class="animatedElement_arrow_up" ';
                                                                        }
                                                                        ?>>&#8679;</div>
                                    </tr>
                                </table>

                            </div>
                            <div class="column_arrow_KU_1">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '015901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '014901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '013901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '012901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '011901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '010911000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '090901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '080901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '070901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '060901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '050901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '040901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '030901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU" <?php if ($value === '020901000000') {
                                                                            echo ' class="animatedElement_arrow_down" ';
                                                                        }
                                                                        ?>>&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_KU"><br></div>
                                    </tr>
                                </table>

                            </div>

                            <div class="column1">
                                <?php switch ($max_level) {
                                    case 15:
                                        echo  '<table>
                                <tr>
                                    <div class="column2">15</div>
                                </tr>
                                <tr>
                                    <div class="column2">14</div>
                                </tr>
                                <tr>
                                    <div class="column2">13</div>
                                </tr>
                                <tr>
                                    <div class="column2">12</div>
                                </tr>
                                <tr>
                                    <div class="column2">11</div>
                                </tr>
                                <tr>
                                    <div class="column2">10</div>
                                </tr>
                                <tr>
                                    <div class="column2">9</div>
                                </tr>
                                <tr>
                                    <div class="column2">8</div>
                                </tr>
                                <tr>
                                    <div class="column2">7</div>
                                </tr>
                                <tr>
                                    <div class="column2">6</div>
                                </tr>
                                <tr>
                                    <div class="column2">5</div>
                                </tr>
                                <tr>
                                    <div class="column2">4</div>
                                </tr>
                                <tr>
                                    <div class="column2">3</div>
                                </tr>
                                <tr>
                                    <div class="column2">2</div>
                                </tr>
                                <tr>
                                    <div class="column2">1</div>
                                </tr>
                        </div>
                        </table>';
                                        break;
                                    default:
                                        echo "ค่าไม่ถูกต้อง";
                                        break;
                                } ?>
                            </div>
                        </div>


                        <div class="mainLift">
                            <div class="lift" id="lift1" flag="free">
                                <div class="gates">
                                    <div class="gate1" style="width: 20px;"></div>
                                    <div class="gate2" style="width: 20px;"></div>
                                </div>
                                <div>
                                </div>
                            </div>
            </section>

            <section class="child2">
                <header class="head">
                    <h2 class="head_sktc"><?php echo $org_name2; ?></h2>
                    <ul class="work-status">
                        <li class="content1">on 6</li>
                        <li class="content2">off 0</li>
                        <li class="content3">all 9</li>
                    </ul>
                </header>

                <div class="container">
                    <div class="flex-item item-2">
                        <h4><?php echo $lift_name2; ?></h4>
                        <table class="tb_kusktc">
                            <tr>
                                <td>1</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </table>

                        <div class="lift_simulation2">
                            <!-- <div class="status_icons3">
                                <span><i class="fa-solid fa-caret-up"></i></span>
                                <span><i class="fa-solid fa-caret-down"></i></span>
                            </div> -->

                            <!-- <div class="column_arrow_SKTC">
                                <p><span class="column_arrow_1_SKTC">&#8681;</span></p>
                                <p><span class="column_arrow_1_SKTC">&#8679;</span>
                                    <span class="column_arrow_1_SKTC">&#8681;</span>
                                </p>
                                <p><span class="column_arrow_1_SKTC">&#8679;</span>
                                    <span class="column_arrow_1_SKTC">&#8681;</span>
                                </p>
                                <p><span class="column_arrow1_SKTC">&#8679;</span></p>
                            </div> -->

                            <div class="column_arrow_SKTC">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_SKTC"><br></div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8679;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8679;</div>
                                    </tr>
                                </table>

                            </div>
                            <div class="column_arrow_SKTC_1">
                                <table>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC">&#8681;</div>
                                    </tr>
                                    <tr>
                                        <div class="column_arrow_1_SKTC"><br></div>
                                    </tr>
                                </table>
                            </div>

                            <div class="column3">
                                <?php switch ($max_level2) {
                                    case 4:
                                        echo  '<table class="tb_floor">
                                    <tr>
                                        <div class="column4">4</div>
                                    </tr>
                                    <tr>
                                        <div class="column4">3</div>
                                    </tr>
                                    <tr>
                                        <div class="column4">2</div>
                                    </tr>
                                    <tr>
                                        <div class="column4">1</div>
                                    </tr>
                            </div>
                            </table>';
                                        break;
                                    default:
                                        echo "ค่าไม่ถูกต้อง";
                                        break;
                                } ?>
                            </div>
                        </div>
            </section>

            <section class="child3">
                <header class="head">
                    <h3>Status</h3>
                </header>
                <div class="container-status">
                    <div class="icons">
                        <div class="status_icons">
                            <!-- <span><i class="fa-solid fa-caret-up"></i></span>
                            <span>
                                <h3>going up</h3>
                            </span>
                            <span><i class="fa-solid fa-caret-down"></i></span>
                            <span>
                                <h3>going down</h3>
                            </span> -->
                            <span class="icon_up">&#8679;</span>
                            <span>
                                <h3>up</h3>
                            </span>
                            <span class="icon_down">&#8681;</span>
                            <span>
                                <h3>down</h3>
                            </span>
                        </div>

                    </div>
                    <div class="lift-icons">
                        <div class="status_lift-icons">
                            <span><img src="assets/images/closed.png" alt=""></span>
                            <span>
                                <h3>closed</h3>
                            </span>
                            <span><img src="assets/images/opened.png" alt=""></span>
                            <span>
                                <h3>opened</h3>
                            </span>
                            <span><img src="assets/images/closing.png" alt=""></span>
                            <span>
                                <h3>closing</h3>
                            </span>
                            <span><img src="assets/images/opening.png" alt=""></span>
                            <span>
                                <h3>opening</h3>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
    </main>
    <script>
    setInterval(() => {
        console.log(new Date());
    }, 1000);
    </script>
</body>

</html>