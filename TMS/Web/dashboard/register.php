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
                                <h3> Add Users</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-end">
                                <p><a href="register.php">Users</a> <i class="fas fa-caret-right"></i> Add Users</p>
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
                                    <h5 class="modal-title text_white">Add Users</h5>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
                                        $sname = mysqli_real_escape_string($conn, htmlentities($_POST['sname']));
                                        $uname = mysqli_real_escape_string($conn, htmlentities($_POST['uname']));
                                        $pass = mysqli_real_escape_string($conn, htmlentities(md5($_POST['pword'])));


                                        //query
                                        $query2 = "INSERT INTO  `users`(`firstname`,`surname`,`username`,`password`) VALUES('$fname','$sname','$uname','$pass')";
                                        if ($run2 = mysqli_query($conn, $query2)) {
                                    ?>
                                            <script type="text/javascript">
                                                document.addEventListener("DOMContentLoaded", function(event) {
                                                    swal("SUCCESS", "<?php echo "$fname $sname"; ?> Was successfully registered", "success");
                                                    setTimeout(function() {
                                                        window.location = 'register.php';
                                                    }, 2000);
                                                });
                                            </script>
                                    <?php
                                        } else {
                                            die(mysqli_error($conn));
                                        }
                                    }

                                    ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <div class="">
                                            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                        </div>
                                        <div class="">
                                            <input type="text" name="sname" class="form-control" placeholder="Last Name" required>
                                        </div>
                                        <div class="">
                                            <input type="text" name="uname" class="form-control" placeholder="Username" required>
                                        </div>
                                        <div class="">
                                            <input type="password" name="pword" class="form-control" placeholder="Password" required>
                                        </div>

                                        <button type="submit" name="submit" class="btn_1 full_width text-center"> Add User</button>
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
        document.querySelector("title").innerText = "TMS ~ Add Users";
        document.querySelectorAll("nav #sidebar_menu li")[4].classList.add("mm-active");
    </script>
    <?php
    include './end.php';
    ?>