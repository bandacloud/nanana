<?php
include './php/connect.php';
include './php/core.php';
// include './php/filterFile.php';
// include './php/compress-image.php';

if (!loggedin()) {
    header('location:login');
}
//selecting user data
$user = $_COOKIE['uid'];
$query1 = "SELECT `firstname`,`surname`,`email`,`password` FROM `users` WHERE `uid`='$user'";
if ($run1 = mysqli_query($conn, $query1)) {
    list($firstname, $surname, $email, $password) = mysqli_fetch_array($run1);
} else {
    die(mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Plant Monitoring System</title>
    <link rel="icon" href="img/logo.png" type="image/png">

    <link rel="stylesheet" href="css/bootstrap1.min.css" />

    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css" />

    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css" />

    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" />

    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css" />

    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css" />

    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css" />

    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css" />

    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css" />

    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css" />

    <link rel="stylesheet" href="vendors/morris/morris.css">

    <link rel="stylesheet" href="vendors/material_icon/material-icons.css" />

    <link rel="stylesheet" href="css/metisMenu.css">

    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
</head>

<body class="crm_body_bg">
    <section class="main_content dashboard_part">
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="QA_table mb_30">
                        <?php
                        include './php/connect.php';
                        $run = mysqli_query($conn, "SELECT * FROM `plants` WHERE `mode`=1") or die(mysqli_error($conn));
                        $row = mysqli_fetch_array($run);
                        $run2 = mysqli_query($conn, "SELECT * FROM `sensor_data` ORDER BY `sid` DESC LIMIT 1") or die(mysqli_error($conn));
                        $row2 = mysqli_fetch_array($run2);
                        ?>
                        <table class="table lms_table_active">
                            <tr>
                                <th scope="col">Plant</th>
                                <td><?php echo $row['plant']; ?></td>
                            </tr>
                            <tr>
                                <th scope="col">Temperature</th>
                                <td>
                                    <?php
                                    if ($row2['temp'] > ((0.2 * $row['temp']) + $row['temp'])) {
                                        echo "Too High";
                                    } else if ($row2['temp'] < ($row['temp'] - (0.2 * $row['temp']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Humidity</th>
                                <td><?php
                                    if ($row2['hum'] > ((0.2 * $row['hum']) + $row['hum'])) {
                                        echo "Too High";
                                    } else if ($row2['hum'] < ($row['hum'] - (0.2 * $row['hum']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Moisture</th>
                                <td><?php
                                    if ($row2['moisture'] > ((0.2 * $row['moisture']) + $row['moisture'])) {
                                        echo "Too High";
                                    } else if ($row2['moisture'] < ($row['moisture'] - (0.2 * $row['moisture']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Nitrogen</th>
                                <td><?php
                                    if ($row2['n'] > ((0.2 * $row['n']) + $row['n'])) {
                                        echo "Too High";
                                    } else if ($row2['n'] < ($row['n'] - (0.2 * $row['n']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Phosphorus</th>
                                <td><?php
                                    if ($row2['p'] > ((0.2 * $row['p']) + $row['p'])) {
                                        echo "Too High";
                                    } else if ($row2['p'] < ($row['p'] - (0.2 * $row['p']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Potassium</th>
                                <td><?php
                                    if ($row2['k'] > ((0.2 * $row['k']) + $row['k'])) {
                                        echo "Too High";
                                    } else if ($row2['k'] < ($row['k'] - (0.2 * $row['k']))) {
                                        echo "Too Low";
                                    } else {
                                        echo "In Range";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/jquery1-3.4.1.min.js"></script>

    <script src="js/popper1.min.js"></script>

    <script src="js/bootstrap1.min.js"></script>

    <script src="js/metisMenu.js"></script>

    <script src="vendors/count_up/jquery.waypoints.min.js"></script>

    <script src="vendors/chartlist/Chart.min.js"></script>

    <script src="vendors/count_up/jquery.counterup.min.js"></script>

    <script src="vendors/swiper_slider/js/swiper.min.js"></script>

    <script src="vendors/niceselect/js/jquery.nice-select.min.js"></script>

    <script src="vendors/owl_carousel/js/owl.carousel.min.js"></script>

    <script src="vendors/gijgo/gijgo.min.js"></script>

    <script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="vendors/datatable/js/jszip.min.js"></script>
    <script src="vendors/datatable/js/pdfmake.min.js"></script>
    <script src="vendors/datatable/js/vfs_fonts.js"></script>
    <script src="vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="vendors/datatable/js/buttons.print.min.js"></script>
    <script src="js/chart.min.js"></script>

    <script src="vendors/progressbar/jquery.barfiller.js"></script>

    <script src="vendors/tagsinput/tagsinput.js"></script>

    <script src="vendors/text_editor/summernote-bs4.js"></script>

    <script src="js/custom.js"></script>
</body>

</html>