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
        <div class="container-flpid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">PATIENTS</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right">
                            <a href="add-patient.php" class="au-btn au-btn-icon au-btn--green au-btn--small"><i class="zmdi zmdi-plus"></i>Add Patient</a>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Gender</th>
                                    <th>Contact</th>
                                    <th>History</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM `patients` ORDER BY `pid` DESC";
                                $run = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                while ($row = mysqli_fetch_array($run)) {
                                ?>
                                    <tr class="tr-shadow">
                                        
                                        <td><?php echo $row['fname']; ?></td>
                                        <td><?php echo $row['sname']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['contact']; ?></td>
                                        <td><?php echo $row['history']; ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="patient-edit.php?pid=<?php echo $row['pid'];?>">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <a href="patient-delete.php?pid=<?php echo $row['pid'];?>" onclick="return confirm('Delete <?php echo $row['fname'].' '.$row['sname'];?>?')">
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
    document.querySelector('li.patients').classList.add('active');
    document.querySelector('li.patients-m').classList.add('active');
    document.querySelector('title').innerText="ESDS - Patients";
</script>