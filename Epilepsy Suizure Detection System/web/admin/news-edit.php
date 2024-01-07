<?php
include './head.php';
include './sidebar.php';
include './page-container.php';


if (isset($_GET['nid'])) {
    if (!empty($_GET['nid'])) {
        $id = mysqli_real_escape_string($conn, $_GET['nid']);
        $sql = "SELECT `title`,`details` FROM `news` WHERE `nid`=$id";
        if ($query_run = mysqli_query($conn, $sql)) {
            list($old_title, $old_details) = mysqli_fetch_array($query_run);
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
                        <div class="card-header">Edit News</div>
                        <div class="card-body">

                            <?php
                            if (isset($_POST['submit'])) {
                                $id = mysqli_real_escape_string($conn, htmlentities($_POST['nid']));
                                $title = mysqli_real_escape_string($conn, htmlentities($_POST['title']));
                                $details = mysqli_real_escape_string($conn, $_POST['details']);

                                $sql = "UPDATE `news` SET `title`='$title', `details`='$details' WHERE `nid`=$id";
                                if (mysqli_query($conn, $sql)) {
                                ?>
                                    <script>
                                        swal("SUCCESS", "News was successfully Updated", "success");
                                        setTimeout(function() {
                                            window.location = 'news-edit.php?nid=<?php echo $id;?>'
                                        }, 1000);
                                    </script>
                                <?php
                                } else {
                                    die(mysqli_error($conn));
                                }
                            }
                            ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id;?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">News Title</label>
                                    <input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Title" value="<?php echo isset($old_title) ? $old_title : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Details</label>
                                    <textarea name="details" id="textarea-input" rows="9" placeholder="Enter Details" class="form-control"><?php echo isset($old_details) ? $old_details : ''; ?></textarea>
                                </div>
                                <input type="hidden" name="nid" value="<?php echo $id;?>">
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
    document.querySelector('li.news').classList.add('active');
    document.querySelector('li.news-m').classList.add('active');
    document.querySelector('title').innerText="ESDS - Edit News";
</script>