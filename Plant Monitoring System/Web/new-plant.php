<?php
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
                            <h3 class="mb-0">Add New Plant</h3>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit'])) {
                        $plant = mysqli_real_escape_string($conn, $_POST['plant']);
                        $temp = mysqli_real_escape_string($conn, $_POST['temp']);
                        $hum = mysqli_real_escape_string($conn, $_POST['hum']);
                        $moisture = mysqli_real_escape_string($conn, $_POST['moisture']);
                        $n = mysqli_real_escape_string($conn, $_POST['n']);
                        $p = mysqli_real_escape_string($conn, $_POST['p']);
                        $k = mysqli_real_escape_string($conn, $_POST['k']);

                        $query = "INSERT INTO `plants`(`plant`,`temp`,`hum`,`moisture`,`n`,`p`,`k`) VALUES('$plant','$temp','$hum','$moisture','$n','$p','$k')";
                        if (mysqli_query($conn, $query)) {
                        ?>
                            <script>
                                swal("","<?php echo $plant;?> was added successfully added", "success");
                            </script>
                        <?php
                        } else {
                            die(mysqli_error($conn));
                        }
                    }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label" for="plant">Plant Name</label>
                            <input type="text" name="plant" class="form-control" id="plant" placeholder="e.g Tomato" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="temp">Max Temperature</label>
                            <input type="text" name="temp" class="form-control" id="temp" placeholder="e.g 40" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="hum">Min Humidity</label>
                            <input type="text" name="hum" class="form-control" id="hum" placeholder="e.g 50" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="moisture">Soil Moisture Content</label>
                            <input type="text" name="moisture" class="form-control" id="moisture" placeholder="e.g 70" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nitrogen">Nitrogen Content</label>
                            <input type="text" name="n" class="form-control" id="nitrogen" placeholder="e.g 255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p">Phosphorus Content</label>
                            <input type="text" name="p" class="form-control" id="p" placeholder="e.g 255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p">Potassium Content</label>
                            <input type="text" name="k" class="form-control" id="p" placeholder="e.g 255" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="submit" class="btn btn-secondary rounded-pill">Submit</button>
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
    document.querySelector("#sidebar_menu .plants").classList.add("mm-active");
</script>