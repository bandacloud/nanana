<?php
include '../php/connect.php';

if (isset($_GET['gid'])) {
    $gid = mysqli_real_escape_string($conn, $_GET['gid']);

    $sql = "SELECT `image` FROM `gallery` WHERE `gid`=$gid";
    if ($query_run = mysqli_query($conn, $sql)) {
        list($file) = mysqli_fetch_array($query_run);
        $sql = "DELETE FROM `gallery` WHERE `gid`=$gid";
        if ($query_run = mysqli_query($conn, $sql)) {
            if (@unlink('../gallery/' . $file)) {
                header('location: gallery.php');
            } else {
                header('location: gallery.php');
            }
        } else {
            die(mysqli_error($conn));
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>