<?php 
session_start();
include("includes/config.php");

define("TITLE", "Template");
define("HEADER", "Template");
define("BREADCRUMB", "Temp");

if(isset($_POST['login'])){
    $username = trim(stripslashes(stripcslashes(mysqli_real_escape_string($conStr, $_POST['username']))));
    $password = trim(stripslashes(stripcslashes(mysqli_real_escape_string($conStr, $_POST['password']))));
    
    if(empty($username)){ array_push($errs, $usernameError = "required"); }
    if(empty($password)){ array_push($errs, $passwordError = "required"); }
    
    #verify credentials 
    if(count($errs) == 0){
        $password = md5($password);
        $query = mysqli_query($conStr, "SELECT * FROM administrators WHERE (username='$username' OR email='$username') AND pwd='$password'");
        if(mysqli_num_rows($query) > 0){
            $userData = mysqli_fetch_array($query);
            $userId = $userData['id'];
            $userStatus = $userData['status'];
            $userRole = $userData['role'];
            $roleStatus = getDBCol('roles',$userRole,'status');
            if($userStatus != 'active'){
                $emsg = "sorry, your account is inactive. contact admin for resolution";
            }
            if($roleStatus != 'active'){
                $emsg = "sorry, your account group is inactive. contact admin for resolution";
            }
            else{
                $_SESSION['kfAdmin'] = $userId;
                $_SESSION['kfaMsg'] = "You have been logged in. Kindly pick up from where you left";
                header("Location: index.php");
            }
        }
        else{
            $emsg = "Go ye away from me. You sinner"; 
        }
    }
    
}

include("includes/head.php");

?>


<body class="bg-dark">

    <div class="container-fluid">
        <div class="mx-md-5 mx-0">
            <?php include("includes/header.php"); ?>
            <main class="mt-5">
                <div class="d-flex justify-content-center">
                    <div class="col-md-3">
                        <div class="card rounded-xlg border-0">
                            <div class="card-body">
                                <div class="text-center">
                                    <h4 class="card-title">Admin Login</h4>
                                    <p class="lead"><strong>Kindly Lorem ipsum dolor sit amet, consectetur adipisicing.</strong></p>
                                </div>
                                <form class="mt-5 mx-5" action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Username *</label>
                                            <input type="text" name="username" class="form-control">
                                            <span class="text-danger"><?php if(isset($usernameError)){echo $usernameError; } ?></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control">
                                            <span class="text-danger"><?php if(isset($passwordError)){echo $passwordError; } ?></span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="switch1">
                                                <label class="custom-control-label" for="switch1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" name="login" class="btn-block btn bg-theme">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <?php include("includes/foot.php"); ?>
            <?php include("includes/footer.php"); ?>
