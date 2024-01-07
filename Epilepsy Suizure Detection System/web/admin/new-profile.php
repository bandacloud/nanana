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

    $player_name = mysqli_real_escape_string($conn, $_POST['player_name']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $yob = mysqli_real_escape_string($conn, htmlentities($_POST['yob']));
    $category = mysqli_real_escape_string($conn, htmlentities($_POST['category']));
    $position = mysqli_real_escape_string($conn, htmlentities($_POST['position']));
    $weight = mysqli_real_escape_string($conn, htmlentities($_POST['weight']));
    $height = mysqli_real_escape_string($conn, htmlentities($_POST['height']));
    $games_played = mysqli_real_escape_string($conn, nl2br($_POST['games_played']));

    $_SESSION['player_name'] = $player_name;
    $_SESSION['nationality'] = $nationality;
    $_SESSION['yob'] = $yob;
    $_SESSION['category'] = $category;
    $_SESSION['position'] = $position;
    $_SESSION['weight'] = $weight;
    $_SESSION['height'] = $height;
    $_SESSION['games_played'] = $games_played;

    //new image name with its particular extension
    $image_new_name = filter_file($player_name .'-'. date('Ymd-His') . $extension);

    $location = '../profiles/';

    //checking if file to be uploaded is an image
    if ($image_type == 'image/JPG' || $image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/jpg') {
        //checking if both audio and image are uploaded
        if (compressImage($image_tmp_name, $location . $image_new_name, 40)) {
            $sql = "INSERT INTO `profile`(`image`,`name`,`nationality`,`yob`,`category`,`position`,`weight`,`height`,`games_played`) VALUES('$image_new_name','$player_name','$nationality','$yob','$category','$position','$weight','$height','$games_played')";
            //checking if the query has run successfully
            if (mysqli_query($conn, $sql)) {
                unset(
                    $_SESSION['player_name'],
                    $_SESSION['nationality'],
                    $_SESSION['yob'],
                    $_SESSION['category'],
                    $_SESSION['position'],
                    $_SESSION['weight'],
                    $_SESSION['height'],
                    $_SESSION['games_played']
                )
                ?>
                <script type="text/javascript">
                    swal("SUCCESS", "<?php echo $player_name;?> was successfully Registered", "success");
                </script>
            <?php
            } else {
                die(mysqli_error($conn));
            }
        } else {
            ?>
            <script type="text/javascript">
                swal("ERROR", "Failed to register <?php echo $player_name;?>", "error");
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
                        <div class="card-header">Player Profile</div>
                        <div class="card-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                <input type="file" name="image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" accept="image/*" multiple required />
                                <label for="file-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                    </svg> <span>Player Image</span>
                                </label>
                                <div class="form-group">
                                    <label for="player_name" class="control-label mb-1">Player Name</label>
                                    <input id="player_name" name="player_name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Player Name" value="<?php echo isset($_SESSION['player_name']) ? $_SESSION['player_name'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nationality" class="control-label mb-1">Nationality</label>
                                    <input id="nationality" name="nationality" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Nationality" value="<?php echo isset($_SESSION['nationality']) ? $_SESSION['nationality'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="yob" class="control-label mb-1">Year of Birth</label>
                                    <input id="yob" name="yob" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="YYYY" value="<?php echo isset($_SESSION['yob']) ? $_SESSION['yob'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="control-label mb-1">Sports Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="" disabled selected>Select</option>
                                        <?php

                                         echo isset($_SESSION['category']) ? '<option>'.$_SESSION['category'].'</option>' : '';
                                        
                                        $run = mysqli_query($conn, "SELECT * FROM `categories` ORDER BY `cid` DESC") or die(mysqli_error($conn));
                                        while ($row = mysqli_fetch_array($run)) {
                                        ?>
                                            <option><?php echo $row['category']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="position" class="control-label mb-1">Position</label>
                                    <input id="position" name="position" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Position" value="<?php echo isset($_SESSION['position']) ? $_SESSION['position'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="weight" class="control-label mb-1">Weight</label>
                                    <input id="weight" name="weight" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Weight" value="<?php echo isset($_SESSION['weight']) ? $_SESSION['weight'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="height" class="control-label mb-1">Height</label>
                                    <input id="height" name="height" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Height" value="<?php echo isset($_SESSION['height']) ? $_SESSION['height'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="games_played" class="control-label mb-1">Games Played</label>
                                    <input id="games_played" name="games_played" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Games Played" value="<?php echo isset($_SESSION['games_played']) ? $_SESSION['games_played'] : ''; ?>" required>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-upload fa-md"></i>&nbsp;
                                        <span id="payment-button-amount">Submit</span>
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
    document.querySelector('li.profile').classList.add('active');
    document.querySelector('title').innerText="SMC - New Profile";
</script>