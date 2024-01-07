<?php
include './php/connect.php';
include './php/core.php';

if(!loggedin()){
    header('location: ./login/');
} else {
    header('location: ./admin/');
}
