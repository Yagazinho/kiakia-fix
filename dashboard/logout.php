<?php
include("includes/config.php");
session_start();
unset($_SESSION['kfAdmin']);
$_SESSION['kfAdmin'] = 0;
$imsg = "You are about to be signed out";
include("includes/foot.php");
header("Refresh: 5; url=login.php")
?>
