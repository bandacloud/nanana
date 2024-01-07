<?php
include './sidenav.php';
include './header.php';
?>
<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="dashboard_header mb_50">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboard_header_title">
                                <h3> Settings</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-end">
                                <p><a href="settings.php"><?php echo $firstname; ?></a> <i class="fas fa-caret-right"></i> Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">

                            <div class="modal-content cs_modal">
                                <div class="modal-header theme_bg_1 justify-content-center">
                                    <h5 class="modal-title text_white">Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
                                        $sname = mysqli_real_escape_string($conn, htmlentities($_POST['sname']));
                                        $uname = mysqli_real_escape_string($conn, htmlentities($_POST['uname']));
                                        $new_pass = mysqli_real_escape_string($conn, htmlentities(md5($_POST['new_pword'])));

                                        if ($new_pass == '') {
                                            //query
                                            $query2 = "UPDATE `users` SET `firstname`='$fname',`surname`='$sname',`username`='$uname' WHERE `uid`='$user'";
                                            if ($run2 = mysqli_query($conn, $query2)) {
                                                ?>
                                                <script type="text/javascript">
                                                    document.addEventListener("DOMContentLoaded", function(event) {
                                                        swal("SUCCESS", "Details Were Successfully Updated", "success");
                                                        setTimeout(function() {
                                                            window.location = 'settings.php'
                                                        }, 2000);
                                                    });
                                                </script>
                                            <?php
                                            } else {
                                                die(mysqli_error($conn));
                                            }
                                        } else {
                                            //query
                                            $query2 = "UPDATE `users` SET `firstname`='$fname',`surname`='$sname',`username`='$uname', `password`='$new_pass'";
                                            if ($run2 = mysqli_query($conn, $query2)) {
                                            ?>
                                                <script type="text/javascript">
                                                    document.addEventListener("DOMContentLoaded", function(event) {
                                                        swal("SUCCESS", "Settings Were Successfully Updated", "success");
                                                        setTimeout(function() {
                                                            window.location = 'settings.php';
                                                        }, 2000);
                                                    });
                                                </script>
                                    <?php
                                            } else {
                                                die(mysqli_error($conn));
                                            }
                                        }
                                    }
                                    ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <div class="">
                                            <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $firstname; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" name="sname" class="form-control" placeholder="Last Name" value="<?php echo $surname; ?>">
                                        </div>
                                        <div class="">
                                            <input type="text" name="uname" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                                        </div>
                                        <div class="">
                                            <input type="password" name="new_pword" class="form-control" placeholder="New Password (Optional)">
                                        </div>

                                        <button type="submit" name="submit" class="btn_1 full_width text-center"> Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include './footer.php';
    include './scripts.php';
    ?>
    <script>
        document.querySelector("title").innerText = "TMS ~ Settings";
    </script>
    <?php
    include './end.php';
    ?>