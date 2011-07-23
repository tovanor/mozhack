<?php
$title = "Add new RSS Feed";
require_once "header.inc.php";

// Make sure an rss url has been entered
if(!isset($_POST['rss']) || !isset($_POST['nameofrss'])) {
    error("Please enter a url and a name.");
}

$rss = mysql_real_escape_string($_POST['rss']);
$name = mysql_rea_escape_string($_POST['nameofrss']);
$query = mysql_query("INSERT INTO `feeds` (`url`, `name`, `user`) VALUES ('$rss', '$name', '$username')") or die(mysql_error());
?>
<html><head><meta http-equiv="refresh" content="2;url=index.php"></head></html>
