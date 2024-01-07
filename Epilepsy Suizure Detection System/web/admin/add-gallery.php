<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if (isset($_POST['submit'])) {
    $image_name = strtolower($_FILES['image']['name']);
    $image_type = $_FILES['image']['type'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];

    switch ($image_type) {
        case 'image/png':
            $extension = ".png";
            break;
        case 'image/jpg':
            $extension = ".jpg";
            break;
        case 'image/jpeg':
            $extension = ".jpg";
            break;
        case 'image/gif':
            $extension = ".gif";
        default:
            $extension = ".jpg";
    }

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $sport = mysqli_real_escape_string($conn, htmlentities($_POST['sport']));

    $_SESSION['title'] = $title;

    //new image name with its particular extension
    $image_new_name = filter_file('ESDS-' . date('Ymd-His') . $extension);

    $location = '../gallery/';

    //checking if file to be uploaded is an image
    if ($image_type == 'image/JPG' || $image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/jpg') {
        //checking if both audio and image are uploaded
        if (compressImage($image_tmp_name, $location . $image_new_name, 30)) {
            $sql = "INSERT INTO `gallery`(`title`,`image`) VALUES('$title','$image_new_name')";
            //checking if the query has run successfully
            if (mysqli_query($conn, $sql)) {
                unset($_SESSION['title'])
            ?>
                <script>
                    swal("SUCCESS", "Image was successfully uploaded", "success");
                    setTimeout(function() {
                        window.location = 'add-gallery.php';
                    }, 1000);
                </script>
            <?php
            } else {
                die(mysqli_error($conn));
            }
        } else {
            ?>
            <script type="text/javascript">
                swal("ERROR", "Failed to upload <?php echo $title; ?>", "error");
            </script>
        <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            swal("ERROR", "<?php echo $image_new_name; ?> is not an image", "error");
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
                        <div class="card-header">Add Image</div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <input type="file" name="image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" accept="image/*" multiple required />
                                <label for="file-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                    </svg> <span>Select Image</span>
                                </label>
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Image Title</label>
                                    <input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Title" value="<?php echo isset($_SESSION['title']) ? $_SESSION['title'] : ''; ?>" required>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-plus fa-md"></i>&nbsp;
                                        <span id="payment-button-amount">Add Image</span>
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
    document.querySelector('title').innerText = "ESDS - Add Gallery";
</script>