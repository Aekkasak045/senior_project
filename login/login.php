<?php
session_start();
include('con_db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>LoginPage</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">

  <meta name="robots" content="noindex, follow">
  <script nonce="e99ca887-dd90-4ab1-ba6b-b2d5049e91be">
    try {
      (function(w, d) {
        ! function(U, V, W, X) {
          U[W] = U[W] || {};
          U[W].executed = [];
          U.zaraz = {
            deferred: [],
            listeners: []
          };
          U.zaraz._v = "5705";
          U.zaraz.q = [];
          U.zaraz._f = function(Y) {
            return async function() {
              var Z = Array.prototype.slice.call(arguments);
              U.zaraz.q.push({
                m: Y,
                a: Z
              })
            }
          };
          for (const $ of ["track", "set", "debug"]) U.zaraz[$] = U.zaraz._f($);
          U.zaraz.init = () => {
            var ba = V.getElementsByTagName(X)[0],
              bb = V.createElement(X),
              bc = V.getElementsByTagName("title")[0];
            bc && (U[W].t = V.getElementsByTagName("title")[0].text);
            U[W].x = Math.random();
            U[W].w = U.screen.width;
            U[W].h = U.screen.height;
            U[W].j = U.innerHeight;
            U[W].e = U.innerWidth;
            U[W].l = U.location.href;
            U[W].r = V.referrer;
            U[W].k = U.screen.colorDepth;
            U[W].n = V.characterSet;
            U[W].o = (new Date).getTimezoneOffset();
            if (U.dataLayer)
              for (const bg of Object.entries(Object.entries(dataLayer).reduce(((bh, bi) => ({
                  ...bh[1],
                  ...bi[1]
                })), {}))) zaraz.set(bg[0], bg[1], {
                scope: "page"
              });
            U[W].q = [];
            for (; U.zaraz.q.length;) {
              const bj = U.zaraz.q.shift();
              U[W].q.push(bj)
            }
            bb.defer = !0;
            for (const bk of [localStorage, sessionStorage]) Object.keys(bk || {}).filter((bm => bm.startsWith("_zaraz_"))).forEach((bl => {
              try {
                U[W]["z_" + bl.slice(7)] = JSON.parse(bk.getItem(bl))
              } catch {
                U[W]["z_" + bl.slice(7)] = bk.getItem(bl)
              }
            }));
            bb.referrerPolicy = "origin";
            bb.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(U[W])));
            ba.parentNode.insertBefore(bb, ba)
          };
          ["complete", "interactive"].includes(V.readyState) ? zaraz.init() : U.addEventListener("DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
      })(window, document)
    } catch (e) {
      throw fetch("/cdn-cgi/zaraz/t"), e;
    };
  </script>
</head>

<body>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100 wrapBU">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="images/Liftpng.png" alt="IMG">
        </div>
        <form action="login_db.php" method="post" class="login100-form validate-form" >
        <span class="login100-form-Headtitle">
             Welcome <br>To Summary<br>
            <a>ADMIN PANEL</a>
          </span>
          <?php if (isset($_SESSION['error'])) : ?>
            <?php
            echo '<script>alert("You dont have permission to access or Wrong Username or Password try againt")</script>';
            ?>
          <?php endif ?>
          <!-- USERNAME -->
          <div class="wrap-input100 validate-input" data-validate="Valid username is required: ex@abc.xyz">
            <input class="input100" type="text" name="username" placeholder="Username">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
          </div>

          <!-- PASSWORD -->
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

          <!-- LOGINBOTTON -->
          <div class="container-login100-form-btn">
            <button type="submit" name="login_btn" class="login100-form-btn">
              Login
            </button>
          </div>
          <div class="text-center p-t-12">
            <span class="txt1">
            </span>
            <a class="txt2" href="#">
            </a>
          </div>
          <div class="text-center p-t-100">
            <a class="txt2" href="#">
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="vendor/tilt/tilt.jquery.min.js"></script>
  <script>
    $('.js-tilt').tilt({
      scale: 1.1
    })
  </script>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
  </script>

  <script src="js/main.js"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"89ddcefae8d13e14","version":"2024.4.1","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

</html>