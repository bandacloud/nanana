<?php
session_start();
include './head.php';
include './side-bar.php';
include './header.php';
?>

<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="box_header ">
                        <div class="main-title">
                            <h3 class="mb-0">New User</h3>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit'])) {
                        $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
                        $lname = mysqli_real_escape_string($conn, htmlentities($_POST['lname']));
                        $email = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
                        $password = mysqli_real_escape_string($conn, htmlentities(md5($_POST['password'])));
                        $confirm = mysqli_real_escape_string($conn, htmlentities(md5($_POST['confirm_pass'])));

                        $_SESSION['fname']=$fname;
                        $_SESSION['lname']=$lname;
                        $_SESSION['email']=$email;

                        if ($password == $confirm) {
                            //query
                            $query2 = "INSERT INTO `users`(`firstname`,`surname`,`email`,`password`) VALUES('$fname','$lname','$email','$password')";
                            if ($run2 = mysqli_query($conn, $query2)) {
                                unset($_SESSION['fname'], $_SESSION['lname'], $_SESSION['email']);
                                ?>
                                <script type="text/javascript">
                                    document.addEventListener("DOMContentLoaded", function(event) {
                                        swal("", "<?php echo "$fname $lname";?> has been registered successfully", "success");
                                        setTimeout(function() {
                                            window.location = 'new-user.php'
                                        }, 2000);
                                    });
                                </script>
                            <?php
                            } else {
                                die(mysqli_error($conn));
                            }
                        } else {
                            ?>
                            <script type="text/javascript">
                                document.addEventListener("DOMContentLoaded", function(event) {
                                    swal("", "Passwords does not match", "warning");
                                    setTimeout(function() {
                                        window.location = 'new-user.php';
                                    }, 2000);
                                });
                            </script>
                            <?php

                        }
                    }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label" for="plant">First Name</label>
                            <input type="text" name="fname" class="form-control" id="plant" placeholder="Enter First Name" value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="temp">Last Name</label>
                            <input type="text" name="lname" class="form-control" id="temp" placeholder="Enter Last Name" value="<?php echo isset($_SESSION['lname']) ? $_SESSION['lname'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="hum">Email</label>
                            <input type="text" name="email" class="form-control" id="hum" placeholder="Enter Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="moisture">Password</label>
                            <input type="password" name="password" class="form-control" id="moisture" placeholder="Enter Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="moisture">Confirm Password</label>
                            <input type="password" name="confirm_pass" class="form-control" id="moisture" placeholder="Confifrm Password">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="submit" class="btn btn-secondary rounded-pill">Add User</button>
                        </div>
                    </form>
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
    document.querySelector("#sidebar_menu .users").classList.add("mm-active");
</script>