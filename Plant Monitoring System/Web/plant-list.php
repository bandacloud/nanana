<?php
include './head.php';
include './side-bar.php';
include './header.php';
?>

<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>Table</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="serach_field_2">
                                <div class="search_inner">
                                    <form Active="#">
                                        <div class="search_field">
                                            <input type="text" placeholder="Search content here...">
                                        </div>
                                        <button type="submit"> <i class="ti-search"></i> </button>
                                    </form>
                                </div>
                            </div>
                            <div class="add_button ms-2">
                                <a href="add-plant.php" data-bs-toggle="modal" data-bs-target="#addcategory" class="btn_1">Add New</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        mysqli_query($conn, "UPDATE `plants` SET `mode`=0") or die(mysqli_error($conn));
                        mysqli_query($conn, "UPDATE `plants` SET `mode`=1 WHERE `pid`=$id") or die(mysqli_error($conn));
                    }

                    if (isset($_GET['pid'])) {
                        $id = $_GET['pid'];
                        mysqli_query($conn, "DELETE FROM `plants` WHERE `pid`=$id") or die(mysqli_error($conn));
                    }
                    ?>
                    <div class="QA_table mb_30">

                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th scope="col">Plant</th>
                                    <th scope="col">Temperature</th>
                                    <th scope="col">Humidity</th>
                                    <th scope="col">Soil Moisture</th>
                                    <th scope="col">Nitrogen</th>
                                    <th scope="col">Phosphorus</th>
                                    <th scope="col">Potassium</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $run = mysqli_query($conn, "SELECT * FROM `plants` ORDER BY `pid` DESC") or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {

                                ?>
                                    <tr>
                                        <th scope="row"> <a href="#" class="question_content"><?php echo $row['plant']; ?></a></th>
                                        <td><?php echo $row['temp']; ?> &deg;C</td>
                                        <td><?php echo $row['hum']; ?> %</td>
                                        <td><?php echo $row['moisture']; ?> %</td>
                                        <td><?php echo $row['n']; ?> mg/kg</td>
                                        <td><?php echo $row['p']; ?> mg/kg</td>
                                        <td><?php echo $row['k']; ?> mg/kg</td>
                                        <td>
                                            <?php
                                            if ($row['mode'] == 1) {
                                            ?>
                                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['pid']; ?>" class="status_btn">Active</a>

                                            <?php
                                            } else {
                                            ?>
                                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['pid']; ?>" class="status_btn bg-warning">Set</a>
                                            <?php
                                            }
                                            ?>
                                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?php echo $row['pid']; ?>" class="status_btn bg-danger" onclick="return confirm('Confirm deleting <?php echo $row['plant']; ?> plant?')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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