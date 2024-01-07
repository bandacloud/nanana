<!DOCTYPE html>
<html lang="en">

<head>
    <title>ESDS Forgot Credentials</title>
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

    //Define name spaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Include required phpMailer files
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';
    require '../PHPMailer/Exception.php';

    if (isset($_POST['submit'])) {
        $to = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
        $query = "SELECT `email`,`firstname`,`surname` FROM `users` WHERE `email`='$to'";
        if ($query_run = mysqli_query($conn, $query)) {
            if (mysqli_num_rows($query_run) == 0) {
    ?>
                <script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function(event) {
                        swal("ERROR", "<?php echo $to; ?> is not registered", "error");
                    })
                </script>
                <?php
            } else if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_array($query_run)) {
                    $email = $row['email'];
                    $subject = "Password Reset Request Notification";
                    $firstname = $row['firstname'];
                    $surname = $row['surname'];

                    $pm = "
                            <!DOCTYPE html>
                            <html lang=\"en\">
                            <head>
                                <meta charset=\"UTF-8\">
                                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                            </head>
                            <body>
                                <div style=\"background-color:rgba(0,255,0,0.1);padding:1rem;\">
                                    <div style=\"background-color:#fff;border-radius:10px;padding:10px;\">
                                        <div style=\"background-color:#009900;color:#fff;border-radius:15px 15px 0 0;text-align:center;font-size:18px;padding:40px 10px ;font-weight:bold;font-family:arial;\">
                                            <div class=\"text-center bg-dark text-white\">PASSWORD RESET REQUEST</div>
                                        </div>
                                        <h2>Dear $firstname $surname,</h2>
                                        <p>We have received a request to reset the password for your ESDS account</p>
                                        <p>If you made this request, click the button below. If you didn't make the request, you can ignore this email

                                        <p>Please click the button below to reset your credentials.</p>
                                        <center>
                                            <a style=\"text-decoration:none;color:#fff;text-align:center;padding:13px 15px;border-radius:20px;background-color:#009900;\" href=\"https://ESDS.online/login/reset.php?email=$email\" target=\"_blank\">Reset Password</a>
                                        </center>
                                        <br><br>
                                        <center>
                                            <div class=\"padding:5px;text-align:center;background-color:#c9c8c8;\">
                                                    ESDS &copy; " . date('Y') . "
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </body>
                            </html>
                            ";

                    //Create instance of phpMailer
                    $mail = new PHPMailer();

                    //Enable verbose debug output
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

                    //set mailer to use smtp
                    $mail->isSMTP();
                    //define smtp host
                    $mail->Host = "smtp.gmail.com";
                    //enable smtp authentification
                    $mail->SMTPAuth = "true";
                    //set type of encryption (ssl/tls)	
                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    //set port to connect smtp
                    $mail->Port = "587"; //465 for ssl
                    //set gmail username
                    $mail->Username = "beatonndaba@gmail.com";
                    //set gmail password
                    $mail->Password = "tsxngatucbssjwbm";
                    //Set email format to HTML
                    $mail->isHTML(true);
                    //set email subject
                    $mail->Subject = $subject;
                    //set sender email
                    $mail->setFrom($email, "ESDS");
                    //Email body
                    $mail->Body = $pm;
                    //Add recipient
                    $mail->addAddress($to);
                    //Finally send email
                    if ($mail->Send()) {
                ?>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function(event) {
                                swal("SUCCESS", "Reset link was sent successfully. Check Your Email", "success");
                            })
                        </script>
                    <?php
                    } else {
                    ?>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function(event) {
                                swal("ERROR", "<?php echo 'Message could not be sent. Mailer Error: {' . $mail->ErrorInfo . '}'; ?>", "error");
                            })
                        </script>
    <?php
                    }

                    //Closing  smtp connection
                    $mail->smtpClose();
                }
            }
        } else {
            die(mysqli_error($conn));
        }
    }
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-85 p-b-20">
                <form class="login100-form validate-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <span class="login100-form-title p-b-70">
                        PASSWORD RESET
                    </span>
                    <div class="wrap-input100 validate-input m-t-25 m-b-35" data-validate="Enter Email">
                        <input class="input100" type="email" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit" type="submit">
                            <i class="fa fa-envelope mr-2"></i> Reset
                        </button>
                    </div>
                    <div class="m-t-40 text-center">
                        <span class="txt1">
                            Now
                        </span>
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