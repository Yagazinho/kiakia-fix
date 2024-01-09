<?php
include("dashboard/includes/config.php");
if(isset($_GET['u'])){
    $u = $_GET['u'];
    if(isset($_GET['typ'])){
        $uFname = getDBCol('users', $u, 'fname');
        $uLname = getDBCol('users', $u, 'lname');
        $uToken = getDBCol('users', $u, 'token');
        $name = "$uFname $uLname";
        $text = "a member to use the services";
        $userTokenInfo = "Login token: $uToken";
    }
    else{
        $uFname = getDBCol('providers', $u, 'fname');
        $uLname = getDBCol('providers', $u, 'lname');
        $uServiceId = getDBCol('providers', $u, 'service');
        $uServiceNm = getDBCol('services', $u);
        $name = "$uFname $uLname";
        $text = "a provider of $uServiceNm services";
    }
}
else{
    exit();
}

define("TITLE", "Thank You $name");
define("HEADER", "You are now a provider");

include("includes/head.php");
?>


<body>

    <?php include("includes/header.php"); ?>
    <main>
        <?php include("includes/page-header.php"); ?>
        <section id="msg" class="section mt-3 rounded-xlg mx-5 bg-light">
            <div class="container text-center">
                <h3 class="mb-5">Thank You</h3>
                <p class="lead">
                    Hi <?= $name ?> <br>
                    We appreciate your effort to have completedthe registration as <?= $text ?> on our platform. Kindly follow the instruction in the mail that will be sent to you shortly to complete your registration process. <br><br>
                    <?= $userTokenInfo ?><br><br>
                    <Strong>Admin</Strong>
                </p>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
    <?php include("includes/foot.php"); ?>
