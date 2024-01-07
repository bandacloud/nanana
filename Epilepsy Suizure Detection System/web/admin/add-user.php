<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
    $sname = mysqli_real_escape_string($conn, htmlentities($_POST['sname']));
    $email = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
    $mobile = mysqli_real_escape_string($conn, htmlentities($_POST['mobile']));
    $acc_type = mysqli_real_escape_string($conn, htmlentities($_POST['acc_type']));
    $password = mysqli_real_escape_string($conn, htmlentities(md5($_POST['password'])));
    $confirm = mysqli_real_escape_string($conn, htmlentities(md5($_POST['confirm'])));

    $_SESSION['fname'] = $fname;
    $_SESSION['sname'] = $sname;
    $_SESSION['email'] = $email;
    $_SESSION['mobile'] = $mobile;
    $_SESSION['acc_type'] = $acc_type;

    //query
    $query2 = "INSERT INTO  `users`(`firstname`,`surname`,`email`,`type`,`mobile`,`password`) VALUES('$fname','$sname','$email','$acc_type','$mobile','$password')";
    if ($password == $confirm) {
        if ($run2 = mysqli_query($conn, $query2)) {
            unset($_SESSION['fname'], $_SESSION['sname'], $_SESSION['email'], $_SESSION['mobile'], $_SESSION['acc_type']);
        ?>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    swal("SUCCESS", "<?php echo "$fname $sname"; ?> Was successfully registered", "success");
                    setTimeout(function() {
                        window.location = 'users.php';
                    }, 1500);
                });
            </script>
        <?php
        } else {
            die(mysqli_error($conn));
        }
    } else {
        ?>
        <script type="text/javascript">
            swal("WARNING", "Passwords do not match", "warning");
        </script>
<?php
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
                        <div class="card-header">Add User</div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="form-group">
                                    <label for="fname" class="control-label mb-1">First Name</label>
                                    <input id="fname" name="fname" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="First Name" value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="lname" class="control-label mb-1">Last Name</label>
                                    <input id="lname" name="sname" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Last Name" value="<?php echo isset($_SESSION['sname']) ? $_SESSION['sname'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label mb-1">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="control-label mb-1">Mobile</label>
                                    <input id="mobile" name="mobile" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Mobile" value="<?php echo isset($_SESSION['mobile']) ? $_SESSION['mobile'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="acc_type" class="control-label mb-1">Account Type</label>
                                    <select name="acc_type" id="acc_type" class="form-control">
                                        <?php echo isset($_SESSION['acc_type']) ? "<option>".$_SESSION['acc_type']."</option>" : "<option value=\"\" disabled selected>Choose</option>";?>
                                        <option value="1">Admin</option>
                                        <option value="0">Editor</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label mb-1">Password</label>
                                    <input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm" class="control-label mb-1">Confirm Password</label>
                                    <input id="confirm" name="confirm" type="confirm" class="form-control" aria-required="true" aria-invalid="false" placeholder="Password">
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-upload"></i>&nbsp;
                                        <span id="payment-button-amount">Add User</span>
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
<script>
    document.querySelector('li.users').classList.add('active');
    document.querySelector('title').innerText = "ESDS - Add User";
</script>