<?php
function timeSpent($time)
{
    $days = floor($time / (60 * 60 * 24));
    $months = floor($time / (60 * 60 * 24 * 30));
    $years = floor($time / (60 * 60 * 24 * 365));
    $remainder = $time % (60 * 60 * 24);
    $hours = floor($remainder / (60 * 60));
    $remainder = $remainder % (60 * 60);
    $minutes = floor($remainder / 60);
    $seconds = $remainder % 60;

    if ($days == 1) {
        echo $days . ' day ago';
    } else if ($days > 1 && $days <= 30) {
        echo $days . ' days ago';
    } else if ($days > 730) {
        echo $years . ' years ago';
    } else if ($days > 365 && $days <= 730) {
        echo $years . ' year ago';
    } else if ($days > 60 && $days <= 365) {
        echo $months . ' months ago';
    } else if ($days > 30) {
        echo $months . ' month ago';
    } else if ($days > 1) {
        echo $days . ' days ago';
    } else if ($days == 0 && $hours == 0 && $minutes == 0) {
        echo 'just now';
    } else if ($days == 0 && $hours == 0 && $minutes == 1) {
        echo $minutes . ' minute ago';
    } else if ($days == 0 && $hours == 0) {
        echo $minutes . ' minutes ago';
    } else if ($days == 0 && $hours == 1) {
        echo $hours . ' hour ago';
    } else if ($days == 0 && $hours > 1) {
        echo $hours . ' hours ago';
    }
}
// echo md5("admin");