<?php
include '../php/connect.php';
include '../php/core.php';
if (!loggedin()) {
    header('location:../login');
}

//selecting user data
$user = $_SESSION['uid'];
$query = "SELECT `firstname`,`surname`,`username`,`password` FROM `users` WHERE `uid`='$user'";
if ($run1 = mysqli_query($conn, $query)) {
    list($firstname, $surname, $username, $password) = mysqli_fetch_array($run1);
} else {
    die(mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>
    <link rel="icon" href="img/logo-ico.png" type="image/png" />

    <link rel="stylesheet" href="css/bootstrap1.min.css" />

    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css" />

    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css" />

    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" />

    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css" />

    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css" />

    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css" />

    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css" />

    <link rel="stylesheet" href="vendors/datepicker/date-picker.css" />

    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css" />

    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css" />

    <link rel="stylesheet" href="vendors/morris/morris.css" />

    <link rel="stylesheet" href="vendors/material_icon/material-icons.css" />

    <link rel="stylesheet" href="css/metisMenu.css" />

    <link rel="stylesheet" href="css/style1.css" />

    <link rel="stylesheet" href="css/main.css" />

    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS" />

    <script src="../js/sweetalert.min.js"></script>

</head>

<body class="crm_body_bg">
    <nav class="sidebar">
        <div class="logo d-flex justify-content-between">
            <a href="index.php"><img src="img/logo.png" alt="TMS" /></a>
            <div class="sidebar_close_icon d-lg-none">
                <i class="ti-close"></i>
            </div>
        </div>
        <ul id="sidebar_menu">
            <li class="">
                <a class="has-arrow" href="#" aria-expanded="false">
                    <img src="img/menu-icon/dashboard.svg" alt="" />
                    <span>Dashboard</span>
                </a>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow" href="#" aria-expanded="false">
                    <img src="img/menu-icon/9.svg" alt="" />
                    <span>Analytics</span>
                </a>
                <ul>
                    <li><a href="analytics.php">Charts</a></li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow" href="#" aria-expanded="false">
                    <img src="img/menu-icon/10.svg" alt="">
                    <span>Users</span>
                </a>
                <ul>
                    <li><a href="register.php">Add Users</a></li>
                    <li><a href="users-list.php">Users List</a></li>
                </ul>
            </li>
        </ul>
    </nav>