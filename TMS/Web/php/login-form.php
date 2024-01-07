<?php
include '../php/connect.php';
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, htmlentities($_POST['username']));
    $password = mysqli_real_escape_string($conn, htmlentities($_POST['password']));
    $pword_hash = md5($password);
    $_SESSION['username']=$username;

    $query = "SELECT `password`,`uid` FROM `users` WHERE `username`='$username'";
    if ($query_run = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($query_run) == 0) {
            unset($_SESSION['username']);
            ?>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    swal("ERROR", "Incorrect Username", "error");
                })
            </script>
            <?php
        } else if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_array($query_run)) {
                $db_username = $row['password'];
                $db_password = $row['password'];
                if ($pword_hash == $db_password) {
                    //storing user id as session
                    $_SESSION['uid'] = $row['uid'];
                    //clearing username session
                    unset($_SESSION['username']);
                    header('location: ../dashboard');
                } else {
                ?>
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function(event) {
                            swal("ERROR", "Incorrect Password", "error");
                        });
                    </script>
                    <?php
                }
            }
        }
    } else {
        die(mysqli_error($conn));
    }
}
