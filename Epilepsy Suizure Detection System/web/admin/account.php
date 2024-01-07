<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
    $lname = mysqli_real_escape_string($conn, htmlentities($_POST['lname']));
    $email = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
    $mobile = mysqli_real_escape_string($conn, htmlentities($_POST['mobile']));
    $password = mysqli_real_escape_string($conn, htmlentities($_POST['password']));
    $hashed = md5($password);

    if (empty($password)) {
        $query2 = "UPDATE `users` SET `firstname`='$fname',`surname`='$lname',`email`='$email',`mobile`='$mobile' WHERE `uid`='$user'";
        if ($run2 = mysqli_query($conn, $query2)) {
        ?>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    swal("SUCCESS", "Profile was successfully updated", "success");
                    setTimeout(function() {
                        window.location = 'account.php'
                    }, 2000);
                });
            </script>
        <?php
        } else {
            die(mysqli_error($conn));
        }
    } else {
        $query2 = "UPDATE `users` SET `firstname`='$fname',`surname`='$lname',`email`='$email',`mobile`='$mobile',`password`='$hashed' WHERE `uid`='$user'";
        if ($run2 = mysqli_query($conn, $query2)) {
        ?>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    swal("SUCCESS", "Profile was successfully updated", "success");
                    setTimeout(function() {
                        window.location = 'account.php'
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
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Account</div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="fname" class="control-label mb-1">First Name</label>
                                    <input id="fname" name="fname" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="First Name" value="<?php echo $firstname; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="lname" class="control-label mb-1">Last Name</label>
                                    <input id="lname" name="lname" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Last Name" value="<?php echo $surname; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label mb-1">Email</label>
                                    <input id="email" name="email" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email" value="<?php echo $email; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="control-label mb-1">Mobile</label>
                                    <input id="mobile" name="mobile" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Mobile" value="<?php echo $mobile; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="control-label mb-1">Password</label>
                                    <input id="mobile" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" placeholder="Password">
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-upload"></i>&nbsp;
                                        <span id="payment-button-amount">Update</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './footer.php'; ?>
        </div>
    </div>
</div>

<?php include './scripts.php'; ?>