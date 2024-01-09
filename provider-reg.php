<?php
include("dashboard/includes/config.php");

define("TITLE", "Become a Provider");
define("HEADER", "Become a Provider");
$showReg = false;

#validating nin
if(isset($_POST['validateNIN'])){
    $nin = trim(mysqli_real_escape_string($conStr, $_POST['nin']));
    if(empty($nin)){
        array_push($errs, $ninError = "please enter a valid NIN");
    }
    if($nin != "" && strlen($nin) < 11){
        array_push($errs, $ninError = "NIN must be up to 11 chars");
    }
    $checkNIN = mysqli_num_rows(mysqli_query($conStr, "SELECT * FROM nins WHERE nin='$nin'"));
    $checkNIN2 = mysqli_num_rows(mysqli_query($conStr, "SELECT * FROM nins WHERE nin='$nin' AND status<>'active'"));
    if($checkNIN2 > 0){
        $emsg = "NIN '$nin' is inactive. Try again";
    }
    elseif($checkNIN > 0){
        $imsg = "NIN '$nin' found, please fill the registration form appropriately";
        $showReg = true;
    }
    if(($nin != "") && (!$checkNIN > 0) && (!$checkNIN2 > 0)){
        $emsg = "NIN '$nin' not found";
    }
}


if(isset($_POST['regProvider'])){
    $showReg = true;
    #collection and scrutiny of data from form 
    $nin = $_POST['nin'];
    $userName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['userName'])));
    $fname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['fname'])));
    $lname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['lname'])));
    $phone  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['phone'])));
    $dob  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['dob'])));
    $email  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['email'])));
    $pwd  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd'])));
    $pwd2  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd2'])));
    
    $gender = trim(intval($_POST['gender']));
    $service = trim(intval($_POST['service']));
    $state = trim(intval($_POST['state']));
    
    #validating the data
    if(empty($userName)){
        array_push($errs, $userNameError = "Please enter a provider name");
    }
    if(empty($fname)){
        array_push($errs, $fnameError = "Please enter a value");
    }
    if(empty($lname)){
        array_push($errs, $lnameError = "Please enter a value");
    }
    if(empty($email)){
        array_push($errs, $emailError = "Please enter a value");
    }
    if(empty($phone)){
        array_push($errs, $phoneError = "Please enter a value");
    }
    if(empty($dob)){
        array_push($errs, $dobError = "Please enter a value");
    }
    if(empty($pwd)){
        array_push($errs, $pwdError = "Please enter a value");
    }
    if(empty($pwd2)){
        array_push($errs, $pwd2Error = "Please enter a value");
    }

    if($gender == 0){
        array_push($errs, $genderError = "Please select a value");
    }
    if($service == 0){
        array_push($errs, $serviceError = "Please select a value");
    }
    if($state == 0){
        array_push($errs, $stateError = "Please select a value");
    }
    
    if(($pwd != "" && $pwd2 !="") && ($pwd != $pwd2)){
         array_push($errs, $pwdError = "password mismatch");
    }
    
    //pevent duplicate data in database table
    if(!empty($userName) && !empty($email) && !empty($phone)){
        $checkProvider = mysqli_query($conStr, "SELECT * FROM providers WHERE username='$userName'");
        $checkProvider2 = mysqli_query($conStr, "SELECT * FROM providers WHERE email='$email'");
        $checkProvider3 = mysqli_query($conStr, "SELECT * FROM providers WHERE phone='$phone'");
        if(mysqli_num_rows($checkProvider) > 0){
           array_push($errs, $userNameError = "username already taken");
        }
        if(mysqli_num_rows($checkProvider2) > 0){
            array_push($errs, $emailError = "email exists");
        }
        if(mysqli_num_rows($checkProvider3) > 0){
            array_push($errs, $phoneError = "phone exists");
        }
    }
    //proceed with data storage when there is no error
    if(count($errs) == 0){
        $uStr = 'kfp-';
        $gID  = $uStr.mt_rand(000,999);
        $cryptedPwd = md5($pwd2);
        $query  = mysqli_query($conStr, "INSERT INTO providers(gID, nin, username, fname, lname, email, phone, gender, service, state, dob, pwd, dc) VALUES('$gID', '$nin', '$userName', '$fname', '$lname', '$email', '$phone', $gender, $service, $state, '$dob', '$cryptedPwd', NOW())");
        if($query){
            $smsg = "Provider '$userName' saved successfully";
            $uId = mysqli_insert_id($conStr);
            header("Refresh: 5; url=thank-you.php?u=$uId");
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

include("includes/head.php");
?>



<body>

    <?php include("includes/header.php"); ?>
    <main>
        <?php include("includes/page-header.php"); ?>
        <section id="banner" class="section mt-3 rounded-xlg mx-5 bg-light">
            <div class="container">
                <h3 class="text-center mb-5">Kindly enter your NIN below to continue</h3>
                <form action="" class="" method="post">
                    <?php if($showReg != true): ?>
                    <div class="row checkNIN">
                        <div class="col-10">
                            <input type="text" name="nin" class="form-control form-control-lg w-100 rounded-xlg only-num" maxlength="11" value="<?php if(isset($_POST['nin'])){ echo $_POST['nin']; } ?>" autofocus>
                            <span class="text-danger"><?php if(isset($ninError)){echo $ninError; } ?></span>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-lg btn-block btn-dark rounded-xlg" name="validateNIN">
                                Validate
                            </button>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row regForm">
                        <fieldset>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">NIN *</label>
                                    <input type="text" class="form-control" name="nin" value="<?php if(isset($_POST['nin'])) {echo $_POST['nin']; } ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Username *</label>
                                    <input type="text" class="form-control" name="userName" value="<?php if(isset($_POST['userName'])) {echo $_POST['username']; } ?>">
                                    <span class="text-danger"><?php if(isset($userNameError)){echo $userNameError; } ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">First Name</label>
                                    <input type="text" class="form-control" name="fname" value="<?php if(isset($_POST['fname'])) {echo $_POST['fname']; } ?>">
                                    <span class="text-danger"><?php if(isset($fnameError)){echo $fnameError; } ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="<?php if(isset($_POST['lname'])) {echo $_POST['lname']; } ?>">
                                    <span class="text-danger"><?php if(isset($lnameError)){echo $lnameError; } ?></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Email Address</label>
                                    <input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email']; } ?>">
                                    <span class="text-danger"><?php if(isset($emailError)){echo $emailError; } ?></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Phone No</label>
                                    <input type="text" class="form-control only-num" name="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone']; } ?>">
                                    <span class="text-danger"><?php if(isset($phoneError)){echo $phoneError; } ?></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Birthdate</label>
                                    <input type="date" class="form-control" name="dob" value="<?php if(isset($_POST['dob'])){echo $_POST['dob']; } ?>">
                                    <span class="text-danger"><?php if(isset($dobError)){echo $dobError; } ?></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Gender</label>
                                    <select name="gender" id="" class="form-control form-control-select">
                                        <option value="">--select--</option>
                                        <?php 
                                        $query = mysqli_query($conStr, "SELECT * FROM genders");
                                        while($row = mysqli_fetch_array($query)){
                                        ?>
                                        <option <?php if(isset($_POST['gender']) && $_POST['gender'] == $row['id']) { echo 'selected';} ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php if(isset($genderError)){echo $genderError; } ?></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Service</label>
                                    <select name="service" id="" class="form-control form-control-select">
                                        <option value="">--select--</option>
                                        <?php 
                                        $query = mysqli_query($conStr, "SELECT * FROM services");
                                        while($row = mysqli_fetch_array($query)){
                                        ?>
                                        <option <?php if(isset($_POST['service']) && $_POST['service'] == $row['id']) { echo 'selected';} ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php if(isset($serviceError)){echo $serviceError; } ?></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">State</label>
                                    <select name="state" id="" class="form-control form-control-select">
                                        <option value="">--select--</option>
                                        <?php 
                                        $query = mysqli_query($conStr, "SELECT * FROM states");
                                        while($row = mysqli_fetch_array($query)){
                                        ?>
                                        <option <?php if(isset($_POST['state']) && $_POST['state'] == $row['id']) { echo 'selected';} ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php if(isset($stateError)){echo $stateError; } ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="password" placeholder="Password*" class="form-control" name="pwd" value="<?php if(isset($_POST['pwd'])) {echo $_POST['pwd']; } ?>">
                                    <span class="text-danger"><?php if(isset($pwdError)){echo $pwdError; } ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="password" placeholder="Password Again*" class="form-control" name="pwd2" value="<?php if(isset($_POST['pwd2'])) {echo $_POST['pwd2']; } ?>">
                                    <span class="text-danger"><?php if(isset($pwd2Error)){echo $pwd2Error; } ?></span>
                                </div>
                            </div>
                        </fieldset>
                        <div class="mx-auto mt-5">
                            <button type="submit" name="regProvider" class="btn btn-sm btn-dark text-white px-5 py-2"><i class="fa fa-check-square mr-2"></i>Register</button>
                        </div>
                    </div>
                    <?php endif ?>
                </form>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
    <?php include("includes/foot.php"); ?>
