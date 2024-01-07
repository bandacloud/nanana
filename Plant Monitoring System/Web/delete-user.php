<?php
include './php/connect.php';
?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM `users` WHERE `uid`=$id";
    if ($run = mysqli_query($conn, $query)) {
        header('location:users-list.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>