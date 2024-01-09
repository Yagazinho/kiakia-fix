<?php
session_start();
if(!isset($_SESSION['kfAdmin'])){
    $imsg = "You must log in";
    header("Location: blank.php"); 
}
elseif(!$_SESSION['kfAdmin'] > 0){
    $imsg = "You must log in";
    header("Location: blank.php");
}
else{
    $uId = $_SESSION['kfAdmin'];
    $query = mysqli_query($conStr, "SELECT * FROM administrators WHERE id=$uId");
    $row = mysqli_fetch_array($query);
    $uUsername = $row['username'];
    $uFname = $row['fname'];
    $uLname = $row['lname'];
    $uImage = $row['image'];
}

?>
