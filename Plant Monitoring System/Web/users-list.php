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
                    <div class="QA_table mb_30">

                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th scope="col">FirstName</th>
                                    <th scope="col">LastName</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $run = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `uid` DESC") or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {

                                ?>
                                    <tr>
                                        <td><?php echo $row['firstname'];?></td>
                                        <td><?php echo $row['surname'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><a href="delete-user.php?id=<?php echo $row['uid'];?>" class="status_btn bg-danger" onclick="return confirm('Delete <?php echo $row['firstname'];?>?')"><i class="fa fa-trash"></i></a></td>
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
    document.querySelector("#sidebar_menu .users").classList.add("mm-active");
</script>