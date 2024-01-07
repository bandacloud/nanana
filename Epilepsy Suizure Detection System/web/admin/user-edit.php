<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if($user_type==0){
    header('location:news.php');
}

if (isset($_GET['uid'])) {
    if (!empty($_GET['uid'])) {
        $id = mysqli_real_escape_string($conn, $_GET['uid']);
        $sql = "SELECT `type`,`firstname` FROM `users` WHERE `uid`=$id";
        if ($query_run = mysqli_query($conn, $sql)) {
            list($old_type,$old_firstname) = mysqli_fetch_array($query_run);
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
                        <div class="card-header">Edit Gallery</div>
                        <div class="card-body">

                            <?php
                            if (isset($_POST['submit'])) {
                                $id = mysqli_real_escape_string($conn, htmlentities($_POST['uid']));
                                $firstname = mysqli_real_escape_string($conn, htmlentities($_POST['firstname']));
                                $acc_type = mysqli_real_escape_string($conn, htmlentities($_POST['acc_type']));

                                $sql = "UPDATE `users` SET `type`='$acc_type' WHERE `uid`=$id";
                                if (mysqli_query($conn, $sql)) {
                                ?>
                                    <script>
                                        swal("SUCCESS", "<?php echo $firstname;?>  was successfully Updated", "success");
                                        setTimeout(function() {
                                            window.location = 'users.php?uid=<?php echo $id;?>'
                                        }, 1000);
                                    </script>
                                <?php
                                } else {
                                    die(mysqli_error($conn));
                                }
                            }
                            ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?uid=<?php echo $id;?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="acc_type" class="control-label mb-1">Account Type</label>
                                    <select name="acc_type" id="acc_type" class="form-control">
                                        <option value="<?php echo $old_type;?>">
                                            <?php
                                            if($old_type==1){
                                                echo "Admin";
                                            } else {
                                                echo "Editor";
                                            }
                                            ?>
                                        </option>
                                        <option value="1">Admin</option>
                                        <option value="0">Editor</option>
                                    </select>
                                </div>
                                <input type="hidden" name="uid" value="<?php echo $id;?>">
                                <input type="hidden" name="firstname" value="<?php echo $old_firstname;?>">
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fas fa-exchange-alt"></i>&nbsp;
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
<script>
    document.querySelector('li.users').classList.add('active');
    document.querySelector('li.users-m').classList.add('active');
    document.querySelector('title').innerText="<?php echo "ESDS - Edit $old_firstname";?>";
</script>