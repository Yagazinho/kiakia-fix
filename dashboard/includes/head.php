<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php  
            if(defined("TITLE")){
                print TITLE;
            }
            else{
                print "Dashboard";
            }
        ?>
    </title>
    <link rel="stylesheet" href="../assets/bootstrap-4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/sl-1.5.0/datatables.min.css" />
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="style.css">
</head>
