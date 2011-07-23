<?php

require_once "access.inc.php";

function error($msg) {
    echo $msg;
    require_once('footer.inc.php');
}

$username = "";

if(isset($_COOKIE['mozhack'])) {
    $cookie = explode(':', $_COOKIE['mozhack']);
    $username = $cookie[0];
}
?>
