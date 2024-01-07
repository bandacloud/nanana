<?php
require('./php/core.php');
setcookie('uid',$row['uid'],time()-(86400*40), '/');

header('location:index.php');
?>