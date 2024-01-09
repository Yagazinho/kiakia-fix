<?php 
$host = "localhost";
$user = "root";
$password = "";
$database = "kiakia_fix";

$conStr = mysqli_connect($host, $user, $password, $database);

$smsg = $emsg = $imsg = "";
$errs = [];
$delItem = false;


include('functions.php');

?>
