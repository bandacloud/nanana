<?php
include './head.php';
include './sidebar.php';
include './page-container.php';
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">GALLERY</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right">
                            <a href="add-gallery.php" class="au-btn au-btn-icon au-btn--green au-btn--small"><i class="zmdi zmdi-plus"></i>Upload Images</a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM `gallery` ORDER BY `gid` DESC";
                                $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {
                                ?>
                                    <tr class="tr-shadow">
                                        <td>
                                            <img src="../gallery/<?php echo $row['image']; ?>" class="tbl-img" alt="<?php echo $row['title']; ?>">
                                        </td>
                                        <td><?php echo $row['title']; ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="gallery-edit.php?gid=<?php echo $row['gid'];?>">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <a href="gallery-delete.php?gid=<?php echo $row['gid'];?>" onclick="return confirm('Delete this image?')">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </a>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
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
    document.querySelector('title').innerText="ESDS - Gallery";
</script>