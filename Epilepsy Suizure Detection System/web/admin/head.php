<?php
include '../php/connect.php';
include '../php/core.php';
include '../php/filterFile.php';
include '../php/compress-image.php';

if (!loggedin()) {
    header('location:../login');
}

//selecting user data
$user = $_SESSION['uid'];
$query1 = "SELECT `firstname`,`surname`,`email`,`mobile`,`password`,`type` FROM `users` WHERE `uid`='$user'";

if ($run1 = mysqli_query($conn, $query1)) {
    list($firstname, $surname, $email, $mobile, $password, $user_type) = mysqli_fetch_array($run1);
} else {
    die(mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Malawi College of Distance Education">
    <meta name="keywords" content="education, online learning, distance learning, odl">

    <!-- Title Page-->
    <title></title>

    <!-- Fontfaces CSS-->
    <link rel="icon" href="../images/icon.png">
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Custom Upload File Type -->
    <link rel="stylesheet" href="../css/component.css">
    <link rel="stylesheet" href="../css/normalize.css">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

    <link href="css/style.css" rel="stylesheet">

    <!-- remove this if you use Modernizr -->
    <script>
        (function(e, t, n) {
            var r = e.querySelectorAll("html")[0];
            r.className = r.className.replace(/(^|\s)no-js(\s|$)/, "$1js$2")
        })(document, window, 0);
    </script>
    <noscript>
        <style type="text/css">
            [data-aos] {
                opacity: 1 !important;
                transform: translate(0) scale(1) !important;
            }
        </style>
    </noscript>
    <!-- Sweet Alert -->
    <script src="../js/sweetalert.min.js"></script>
</head>