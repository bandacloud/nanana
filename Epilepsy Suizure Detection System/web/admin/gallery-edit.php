<?php
include './head.php';
include './sidebar.php';
include './page-container.php';


if (isset($_GET['gid'])) {
    if (!empty($_GET['gid'])) {
        $id = mysqli_real_escape_string($conn, $_GET['gid']);
        $sql = "SELECT `title` FROM `gallery` WHERE `gid`=$id";
        if ($query_run = mysqli_query($conn, $sql)) {
            list($old_title,) = mysqli_fetch_array($query_run);
        } else {
            die(mysqli_error($conn));
        }
    }
}
?>

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
                                $id = mysqli_real_escape_string($conn, htmlentities($_POST['gid']));
                                $title = mysqli_real_escape_string($conn, htmlentities($_POST['title']));

                                $sql = "UPDATE `gallery` SET `title`='$title' WHERE `gid`=$id";
                                if (mysqli_query($conn, $sql)) {
                                ?>
                                    <script>
                                        swal("SUCCESS", "Image was successfully Updated", "success");
                                        setTimeout(function() {
                                            window.location = 'gallery-edit.php?gid=<?php echo $id;?>'
                                        }, 1000);
                                    </script>
                                <?php
                                } else {
                                    die(mysqli_error($conn));
                                }
                            }
                            ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?gid=<?php echo $id;?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Title Name</label>
                                    <input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Title" value="<?php echo isset($old_title) ? $old_title : ''; ?>">
                                </div>
                                <input type="hidden" name="gid" value="<?php echo $id;?>">
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
    document.querySelector('li.gallery').classList.add('active');
    document.querySelector('li.gallery-m').classList.add('active');
    document.querySelector('title').innerText="<?php echo "SMS - Edit Gallery"?>";
</script>