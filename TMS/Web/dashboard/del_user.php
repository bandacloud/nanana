<?php
include './sidenav.php';
include './header.php';
?>
<?php
if (isset($_GET['id'], $_GET['name'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $query = "DELETE FROM `users` WHERE `uid`='" . $id . "'";
    if ($run = mysqli_query($conn, $query)) {
?>
        <script>
            swal("SUCCESS", "<?php echo $name; ?> was successfully deleted", "success");
            setTimeout(function() {
                window.location = 'users-list.php'
            }, 1000);
        </script>
<?php
    } else {
        die(mysqli_error($conn));
    }
}
include './footer.php';
include './scripts.php';
include './end.php';
?>