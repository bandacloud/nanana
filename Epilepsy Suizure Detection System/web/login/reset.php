<?php
session_start();
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ESDS Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../images/icon.png" />

    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <meta name="robots" content="noindex, follow">
    <script src="../js/sweetalert.min.js"></script>
    <script nonce="e294cb17-cfa5-466e-abbd-9ab66dd30115">
        (function(w, d) {
            ! function(Y, Z, _, ba) {
                Y[_] = Y[_] || {};
                Y[_].executed = [];
                Y.zaraz = {
                    deferred: [],
                    listeners: []
                };
                Y.zaraz.q = [];
                Y.zaraz._f = function(bb) {
                    return function() {
                        var bc = Array.prototype.slice.call(arguments);
                        Y.zaraz.q.push({
                            m: bb,
                            a: bc
                        })
                    }
                };
                for (const bd of ["track", "set", "debug"]) Y.zaraz[bd] = Y.zaraz._f(bd);
                Y.zaraz.init = () => {
                    var be = Z.getElementsByTagName(ba)[0],
                        bf = Z.createElement(ba),
                        bg = Z.getElementsByTagName("title")[0];
                    bg && (Y[_].t = Z.getElementsByTagName("title")[0].text);
                    Y[_].x = Math.random();
                    Y[_].w = Y.screen.width;
                    Y[_].h = Y.screen.height;
                    Y[_].j = Y.innerHeight;
                    Y[_].e = Y.innerWidth;
                    Y[_].l = Y.location.href;
                    Y[_].r = Z.referrer;
                    Y[_].k = Y.screen.colorDepth;
                    Y[_].n = Z.characterSet;
                    Y[_].o = (new Date).getTimezoneOffset();
                    if (Y.dataLayer)
                        for (const bk of Object.entries(Object.entries(dataLayer).reduce(((bl, bm) => ({
                                ...bl[1],
                                ...bm[1]
                            })), {}))) zaraz.set(bk[0], bk[1], {
                            scope: "page"
                        });
                    Y[_].q = [];
                    for (; Y.zaraz.q.length;) {
                        const bn = Y.zaraz.q.shift();
                        Y[_].q.push(bn)
                    }
                    bf.defer = !0;
                    for (const bo of [localStorage, sessionStorage]) Object.keys(bo || {}).filter((bq => bq.startsWith("_zaraz_"))).forEach((bp => {
                        try {
                            Y[_]["z_" + bp.slice(7)] = JSON.parse(bo.getItem(bp))
                        } catch {
                            Y[_]["z_" + bp.slice(7)] = bo.getItem(bp)
                        }
                    }));
                    bf.referrerPolicy = "origin";
                    bf.src = "../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(Y[_])));
                    be.parentNode.insertBefore(bf, be)
                };
                ["complete", "interactive"].includes(Z.readyState) ? zaraz.init() : Y.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, "zarazData", "script");
        })(window, document);
    </script>
</head>

<body>
    <?php
    include '../php/connect.php';
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
        $pwd = mysqli_real_escape_string($conn, htmlentities(md5($_POST['pwd'])));
        $pwd_co = mysqli_real_escape_string($conn, htmlentities(md5($_POST['pwd_co'])));

        if (!empty($email)) {
            if ($pwd == $pwd_co) {
                if (strlen($_POST['pwd']) >= 5) {
                    $query2 = "UPDATE `users` SET `password`='$pwd' WHERE `email`='$email'";
                    if ($run2 = mysqli_query($conn, $query2)) {
                    ?>
                        <script type="text/javascript">
                            swal("SUCCESS", "Password reset was successful", "success");
                        </script>
                    <?php
                    } else {
                        die(mysqli_error($conn));
                    }
                } else {
                    ?>
                    <script type="text/javascript">
                        swal("WARNING", "Password is too short", "warning");
                    </script>
                <?php
                }
            } else {
                ?>
                <script type="text/javascript">
                    swal("WARNING", "Passwords do not match", "warning");
                </script>
            <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                swal("ERROR", "Email is empty", "error");
            </script>
    <?php
        }
    }
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-85 p-b-20">
                <form class="login100-form validate-form" action="<?php echo $_SERVER['PHP_SELF'] ."?email=". $email;?>" method="POST">
                    <span class="login100-form-title p-b-70">
                        RESET
                    </span>
                    <div class="wrap-input100 validate-input m-t-25 m-b-35" data-validate="Enter New Password">
                        <input class="input100" type="password" name="pwd">
                        <span class="focus-input100" data-placeholder="New Password"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-t-25 m-b-35" data-validate="Confirm Password">
                        <input class="input100" type="password" name="pwd_co">
                        <span class="focus-input100" data-placeholder="Confirm Password"></span>
                    </div>
                    <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $email : ''; ?>">
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit" type="submit">
                            Reset
                        </button>
                    </div>
                    <div class="m-t-40 text-center">
						<a href="index.php" class="txt2">
							Login
						</a>
					</div>
                </form>
            </div>
        </div>
    </div>
    <div id="dropDownSelect1"></div>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>

    <script src="vendor/animsition/js/animsition.min.js"></script>

    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="vendor/select2/select2.min.js"></script>

    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>

    <script src="vendor/countdowntime/countdowntime.js"></script>

    <script src="js/main.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v52afc6f149f6479b8c77fa569edb01181681764108816" integrity="sha512-jGCTpDpBAYDGNYR5ztKt4BQPGef1P0giN6ZGVUi835kFF88FOmmn8jBQWNgrNd8g/Yu421NdgWhwQoaOPFflDw==" data-cf-beacon='{"rayId":"7d28f258bd234f69","version":"2023.4.0","b":1,"token":"cd0b4b3a733644fc843ef0b185f98241","si":100}' crossorigin="anonymous"></script>
</body>

</html>