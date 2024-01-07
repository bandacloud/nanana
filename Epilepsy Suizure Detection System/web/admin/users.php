<?php
include './head.php';
include './sidebar.php';
include './page-container.php';

if($user_type==0){
    header('location:news.php');
}
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">USERS</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right">
                            <a href="add-user.php" class="au-btn au-btn-icon au-btn--green au-btn--small"><i class="zmdi zmdi-plus"></i>Add User</a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM `users` ORDER BY `uid` DESC";
                                $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {
                                ?>
                                    <tr class="tr-shadow">
                                        
                                        <td><?php echo $row['firstname']; ?></td>
                                        <td><?php echo $row['surname']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td>
                                            <?php 
                                                if($row['type']==1){
                                                    echo "Admin";
                                                } else {
                                                    echo "Editor";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="user-edit.php?uid=<?php echo $row['uid'];?>">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <a href="user-delete.php?uid=<?php echo $row['uid'];?>" onclick="return confirm('Delete <?php echo $row['firstname'].' '.$row['surname'];?>?')">
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
    document.querySelector('li.users').classList.add('active');
    document.querySelector('li.users-m').classList.add('active');
    document.querySelector('title').innerText="ESDS - Users";
</script>