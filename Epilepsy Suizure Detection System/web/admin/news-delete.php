<?php
include '../php/connect.php';

if (isset($_GET['nid'])) {
    $nid = mysqli_real_escape_string($conn, $_GET['nid']);

    $sql = "SELECT `image` FROM `news` WHERE `nid`=$nid";
    if ($query_run = mysqli_query($conn, $sql)) {
        list($file) = mysqli_fetch_array($query_run);
        $sql = "DELETE FROM `news` WHERE `nid`=$nid";
        if ($query_run = mysqli_query($conn, $sql)) {
            if (@unlink('../news/' . $file)) {
                header('location:news.php');
            }
        } else {
            die(mysqli_error($conn));
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>