<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, htmlentities($_POST['fname']));
    $sname = mysqli_real_escape_string($conn, htmlentities($_POST['sname']));
    $gender = mysqli_real_escape_string($conn, htmlentities($_POST['gender']));
    $contact = mysqli_real_escape_string($conn, htmlentities($_POST['contact']));
    $history = mysqli_real_escape_string($conn, htmlentities($_POST['history']));

    $_SESSION['fname'] = $fname;
    $_SESSION['sname'] = $sname;
    $_SESSION['gender'] = $gender;
    $_SESSION['contact'] = $contact;
    $_SESSION['history'] = $history;

    //query
    $query2 = "INSERT INTO  `patients`(`fname`,`sname`,`gender`,`contact`,`history`) VALUES('$fname','$sname','$gender','$contact','$history')";
    if ($run2 = mysqli_query($conn, $query2)) {
        unset($_SESSION['fname'], $_SESSION['sname'], $_SESSION['gender'], $_SESSION['contact'], $_SESSION['history']);
?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(event) {
                swal("SUCCESS", "<?php echo "$fname $sname"; ?> Was successfully Added", "success");
                setTimeout(function() {
                    window.location = 'patient-info.php';
                }, 1500);
            });
        </script>
<?php
    } else {
        die(mysqli_error($conn));
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
                        <div class="card-header">Add Patient</div>
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
                                    <label for="acc_type" class="control-label mb-1">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <?php echo isset($_SESSION['gender']) ? "<option>" . $_SESSION['gender'] . "</option>" : "<option value=\"\" disabled selected>Choose</option>"; ?>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contact" class="control-label mb-1">Emergency Contact</label>
                                    <input id="contact" name="contact" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Contact" value="<?php echo isset($_SESSION['contact']) ? $_SESSION['contact'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="history" class="control-label mb-1">Illness History</label>
                                    <input id="history" name="history" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="History" value="<?php echo isset($_SESSION['history']) ? $_SESSION['history'] : ''; ?>" required>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-upload"></i>&nbsp;
                                        <span id="payment-button-amount">Add Patient</span>
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
    document.querySelector('li.patients').classList.add('active');
    document.querySelector('title').innerText = "ESDS - Add Patient";
</script>