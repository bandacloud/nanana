<?php
include './sidenav.php';
include './header.php';
?>
<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="dashboard_header mb_20">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboard_header_title">
                                <h3> Users List</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-end">
                                <p><a href="index.html">Users</a> <i class="fas fa-caret-right"></i> Users List</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="QA_section">
                    <div class="QA_table mb_30">

                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th scope="col">Firstname</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $run = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `uid` DESC") or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {
                                    if ($row['uid'] == $_SESSION['uid']) {
                                        continue;
                                    } else {
                                        $name=$row['firstname'].' '.$row['surname'];
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['firstname']; ?></a></th>
                                            <td><?php echo $row['surname']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><a href="del_user.php?id=<?php echo $row['uid']; ?>&name=<?php echo $row['firstname'];?>" class="status_btn bg-danger" onclick="return confirm('Delete <?php echo $name;?>?')"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        <?php
                                    }
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
    document.querySelector("title").innerText = "TMS ~ Users List";
    document.querySelectorAll("nav #sidebar_menu li")[4].classList.add("mm-active");
</script>
<?php
include './end.php';
?>