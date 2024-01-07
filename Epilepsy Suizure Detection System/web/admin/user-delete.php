<?php
include '../php/connect.php';

if (isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);

    $sql = "DELETE FROM `users` WHERE `uid`=$uid";
    if ($query_run = mysqli_query($conn, $sql)) {
        header('location: users.php');
    } else {
        die(mysqli_error($conn));
    }
}