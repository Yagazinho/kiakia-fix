<?php 
include("includes/config.php");

define("TITLE", "Managing Administrators");
define("HEADER", "Managing Administrators");
define("BREADCRUMB", "administrators");

//page level scripts
$pageURL = "administrators.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-administrator'){
      $cardTitle = "Add Administrator";
  }
    if($_GET['do'] == 'edit-administrator' || $_GET['do'] == 'edit-username' || $_GET['do'] == 'edit-email' || $_GET['do'] == 'update-image' || $_GET['do'] == 'update-pwd'){
        $do = $_GET['do'];
        if($do == 'edit-administrator'){ $title = 'Basic Info'; } 
        elseif($do == 'edit-username'){ $title = 'Username'; }
        elseif($do == 'edit-email'){ $title = 'Email'; }
        elseif($do == 'update-image'){ $title = 'Image'; }
        elseif($do == 'update-pwd'){ $title = 'Password'; }
        if(isset($_GET['do'])) { $id = $_GET['id']; }
        $userName = getDBcol('administrators',$id, 'username');
        $fname = getDBcol('administrators',$id, 'fname');
        $lname = getDBcol('administrators',$id, 'lname');
        $email = getDBcol('administrators',$id, 'email');
        $phone = getDBcol('administrators',$id, 'phone');
        $image = getDBcol('administrators',$id, 'image');
        $role = getDBcol('administrators',$id, 'role');
        $gID = getDBcol('administrators',$id, 'gID');
        $cardTitle = "Edit $title <small class='bg-dark text-white rounded-lg px-2 py-1'>$userName - $gID</small>";
    }
}

//logics
//add
if(isset($_POST['addAdministrator'])){
//    collection and scrutiny of data from form 
    $userName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['userName'])));
    $fname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['fname'])));
    $lname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['lname'])));
    $phone  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['phone'])));
    $email  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['email'])));
    $pwd  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd'])));
    $pwd2  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd2'])));
    
    $role = trim(intval($_POST['role']));
    
    //validating the data
    if(empty($userName)){
        array_push($errs, $userNameError = "Please enter a administrator name");
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
    if(empty($pwd)){
        array_push($errs, $pwdError = "Please enter a value");
    }
    if(empty($pwd2)){
        array_push($errs, $pwd2Error = "Please enter a value");
    }
    
    if($role == 0){
        array_push($errs, $roleError = "Please select a value");
    }
    
    if(($pwd != "" && $pwd2 !="") && ($pwd != $pwd2)){
         array_push($errs, $pwdError = "password mismatch");
    }
    
    //pevent duplicate data in database table
    if(!empty($userName) && !empty($email) && !empty($phone)){
        $checkAdministrator = mysqli_query($conStr, "SELECT * FROM administrators WHERE username='$userName'");
        $checkAdministrator2 = mysqli_query($conStr, "SELECT * FROM administrators WHERE email='$email'");
        $checkAdministrator3 = mysqli_query($conStr, "SELECT * FROM administrators WHERE phone='$phone'");
        if(mysqli_num_rows($checkAdministrator) > 0){
                    array_push($errs, $userNameError = "username already taken");
        }
        if(mysqli_num_rows($checkAdministrator2) > 0){
                    array_push($errs, $emailError = "email exists");
        }
        if(mysqli_num_rows($checkAdministrator3) > 0){
                    array_push($errs, $phoneError = "phone exists");
        }
    }
    //proceed with data storage when there is no error
    if(count($errs) == 0){
        $uStr = 'kfa-';
        $gID  = $uStr.mt_rand(000,999);
        $cryptedPwd = md5($pwd2);
        $query  = mysqli_query($conStr, "INSERT INTO administrators(gID, username, fname, lname, email, phone, role, pwd, dc) VALUES('$gID', '$userName', '$fname', '$lname', '$email', '$phone', $role, '$cryptedPwd', NOW())");
        if($query){
            $smsg = "Administrator '$userName' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

#update
if(isset($_POST['updateBasic'])){
    #collection and scrutiny of data from form
    $fnameFrm  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['fname'])));
    $lnameFrm  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['lname'])));
    $roleFrm = trim(intval($_POST['role']));  
    
    //validating the data
    if(empty($fnameFrm)){
        array_push($errs, $fnameError = "Please enter a value");
    }
    if(empty($lnameFrm)){
        array_push($errs, $lnameError = "Please enter a value");
    }
    if($roleFrm == 0){
        array_push($errs, $roleError = "Please select a value");
    }
    
    //proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE administrators SET fname='$fnameFrm', lname='$lnameFrm', role='$roleFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Administrator '$userName' Basic info updated successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

if(isset($_POST['updateUsername'])){
    #collection and scrutiny of data from form
    $userNameFrm  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['userName']))); 
    
    #validating the data
    if(empty($userNameFrm)){
        array_push($errs, $userNameError = "Please enter a value");
    }
    
    #prevent duplicate data in database table
    if($userNameFrm == $userName){
        array_push($errs, $userExistError = "");
        $emsg = "Modification is required to continue";
    }
    else{
        $checkUserName = mysqli_query($conStr, "SELECT * FROM administrators WHERE username='$userNameFrm'");
        if(mysqli_num_rows($checkUserName) > 0){
            array_push($errs, $userExistError = "");
            $emsg = "User with username '$userNameFrm' already exists. Please choose another name"; 
        }
    }
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE administrators SET username='$userNameFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Administrator '$userName' updated to '$userNameFrm' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

if(isset($_POST['updateEmail'])){
    #collection and scrutiny of data from form
    $emailFrm  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['email']))); 
    
    #validating the data
    if(empty($emailFrm)){
        array_push($errs, $emailError = "Please enter a value");
    }
    
    #prevent duplicate data in database table
    if($emailFrm == $email){
        array_push($errs, $emailExistError = "");
        $emsg = "Modification is required to continue";
    }
    else{
        $checkUserEmail = mysqli_query($conStr, "SELECT * FROM administrators WHERE email='$emailFrm'");
        if(mysqli_num_rows($checkUserEmail) > 0){
            array_push($errs, $emailExistError = "");
            $emsg = "User with email '$emailFrm' already exists. Please choose another name"; 
        }
    }
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE administrators SET email='$emailFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Administrator '$email' updated to '$emailFrm' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

if(isset($_POST['submit'])){
    $uploadPath = "uploads/images/users/admin/";
    #collection and scrutiny of data from form
    $coverImg = $_FILES['coverImg']['name'];
    
    #get file extension
    $fileNameArr = explode(".",$coverImg);
    $ext = strtolower(".".end($fileNameArr));
    $allowedExts = ['.jpg','.png'];
    if(!in_array($ext, $allowedExts)){
        array_push($errs, $coverImgError = "file format '$ext' not supported");
    }
    
    #renamin the image file with custom name
    $newImgName = strtolower($gID.$ext);
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $possibleFile1 = $gID.'.jpg';
        $possibleFile2 = $gID.'.png';
        $query  = mysqli_query($conStr, "UPDATE administrators SET image='$newImgName', du=NOW() WHERE id=$id");
        if($query){
            #check if file exists and remove it
            if(file_exists($uploadPath.$possibleFile1)){ unlink($uploadPath.$possibleFile1); }
            if(file_exists($uploadPath.$possibleFile1)){ unlink($uploadPath.$possibleFile1); }
            
            #move file into desired directory
            if(move_uploaded_file($_FILES['userImage']['tmp_name'], $uploadPath.$newImgName)){
                $smsg = "Administrator profile image updated successfully";    
            }
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage administrator
if(isset($_GET['do']) && isset($_GET['id'])){
    $id = $_GET['id']; 
    $userName = getDBcol('administrators',$id,'username');
    $do = $_GET['do'];
    
    if($do == 'edit-administrator'){}
    if($do == 'dact-administrator'){
        if(changeStatus('administrators', $id, 'inactive') == 'ok'){
            $smsg = "Administrator '$userName' deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-administrator'){
        if(changeStatus('administrators', $id, 'active') == 'ok'){
            $smsg = "Administrator '$userName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }

    if($do == 'del-administrator'){
        $delItem = true;
        $itemType = 'Administrator';
        $item   = $userName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('Administrators', $id) == 'ok'){
                $smsg = "Administrator '$userName' deleted successfully";
                echo "<script>setTimeout(function(){ window.location = '$pageURL'}, 5000);</script>";
            }
            else{ 
                $emsg = "Something went wrong ";
            }
       }
    }
}

include("includes/head.php");

?>

<body class="bg-dark">

    <div class="container-fluid">
        <div class="mx-md-5 mx-0">
            <?php include("includes/header.php"); ?>
            <main>
                <?php include("includes/page-header.php"); ?>

                <div class="row">
                    <?php include("includes/nav.php"); ?>
                    <div class="col-md-10">
                        <div class="card border-0 rounded-xlg">
                            <div class="card-body">
                                <div class="border-bottom py-2 mb-3">
                                    <div class="btn-group">
                                        <a href="administrators.php?do=add-administrator&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="administrators.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="administrators.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="administrators.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-administrator'): ?>
                                                    <div id="add-administrator">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-7">
                                                                    <input type="text" placeholder="username *" class="form-control" name="userName" value="<?php if(isset($_POST['userName'])) {echo $_POST['userName']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($userNameError)){echo $userNameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-5">
                                                                    <select name="role" id="" class="form-control form-control-select">
                                                                        <option value="">--role--</option>
                                                                        <?php 
                                                                        $query = mysqli_query($conStr, "SELECT * FROM roles");
                                                                        while($row = mysqli_fetch_array($query)){
                                                                        ?>
                                                                        <option <?php if(isset($_POST['role']) && $_POST['role'] == $row['id']) { echo 'selected';} ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="text-danger"><?php if(isset($roleError)){echo $roleError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="First Name*" class="form-control" name="fname" value="<?php if(isset($_POST['fname'])) {echo $_POST['fname']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($fnameError)){echo $fnameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="Last Name*" class="form-control" name="lname" value="<?php if(isset($_POST['lname'])) {echo $_POST['lname']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($lnameError)){echo $lnameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="email*" class="form-control" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($emailError)){echo $emailError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="Phone*" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($phoneError)){echo $phoneError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <input type="password" placeholder="Password*" class="form-control" name="pwd" value="<?php if(isset($_POST['pwd'])) {echo $_POST['pwd']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($pwdError)){echo $pwdError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <input type="password" placeholder="Password Again*" class="form-control" name="pwd2" value="<?php if(isset($_POST['pwd2'])) {echo $_POST['pwd2']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($pwd2Error)){echo $pwd2Error; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addAdministrator" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-administrator'): ?>
                                                    <div id="edit-administrator-basicInfo">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <select name="role" id="" class="form-control form-control-select">
                                                                        <option value="">--role--</option>
                                                                        <?php 
                                                                        $query = mysqli_query($conStr, "SELECT * FROM roles");
                                                                        while($row = mysqli_fetch_array($query)){
                                                                        ?>
                                                                        <option <?php if(isset($_POST['role']) && $_POST['role'] == $row['id'] || $role == $row['id']) { echo 'selected';} ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="text-danger"><?php if(isset($roleError)){echo $roleError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="First Name*" class="form-control" name="fname" value="<?php if(isset($_POST['fname'])) {echo $_POST['fname']; } else{ echo $fname; } ?>">
                                                                    <span class="text-danger"><?php if(isset($fnameError)){echo $fnameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <input type="text" placeholder="Last Name*" class="form-control" name="lname" value="<?php if(isset($_POST['lname'])) {echo $_POST['lname']; } else{ echo $lname; } ?>">
                                                                    <span class="text-danger"><?php if(isset($lnameError)){echo $lnameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateBasic" class="btn btn btn-sm btn-primary text-white">Update</button>
                                                            <button type="reset" class="btn btn-sm btn-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-username'): ?>
                                                    <div id="edit-username">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="User Name*" class="form-control" name="userName" value="<?php if(isset($_POST['userName'])) {echo $_POST['userName']; } else{ echo $userName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($userNameError)){echo $userNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateUsername" class="btn btn btn-sm btn-primary text-white">Update</button>
                                                            <button type="reset" class="btn btn-sm btn-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-email'): ?>
                                                    <div id="edit-email">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="email" placeholder="Email *" class="form-control" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email']; } else{ echo $email; } ?>">
                                                                    <span class="text-danger"><?php if(isset($emailError)){echo $emailError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateEmail" class="btn btn btn-sm btn-primary text-white">Update</button>
                                                            <button type="reset" class="btn btn-sm btn-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'update-image'): ?>
                                                    <div id="update-image">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-7">
                                                                    <label for="">Profile Image <small class="text-info">(jpg / png)</small></label>
                                                                    <input type="file" class="form-control form-control-file" name="userImage">
                                                                    <span class="text-danger"><?php if(isset($userImageError)){echo $userImageError; } ?></span>
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <label for="">Current Image</label>
                                                                    <div class="">
                                                                        <img src="uploads/images/users/admin/<?= $image ?>" alt="Admin Avater" class="img-fluid rounded-circle form-user-image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateImage" class="btn btn btn-sm btn-primary text-white">Update</button>
                                                            <button type="reset" class="btn btn-sm btn-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif ?>
                                    <div class="col-md-<?php if(isset($_GET['min']) && $_GET['min'] == 'true'){echo 8;}else{ echo 12;} ?>">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-5">Manage All</h6>
                                                <?php include("includes/del-alert.php"); ?>
                                                <table class="table datatable table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Action</th>
                                                            <th>ID - (Username | Role)</th>
                                                            <th>Full Name</th>
                                                            <th>Contact</th>
                                                            <th>Image</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM administrators");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                            $roleName = getDBcol('roles',$row['role']);
                                                            
                                                            $name = $row['gID']." - (".$row['username']." | ".$roleName.")"; 
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="administrators.php?do=edit-administrator&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Basic"><i class="fa fa-edit"></i></a>
                                                                <a href="administrators.php?do=edit-username&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Username"><i class="fa fa-id-card-o"></i></a>
                                                                <a href="administrators.php?do=edit-email&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Email"><i class="fa fa-envelope"></i></a>
                                                                <a href="administrators.php?do=update-image&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-info" title="Update Image"><i class="fa fa-photo"></i></a>
                                                                <a href="administrators.php?do=update-pwd&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-dark" title="Update Password"><i class="fa fa-lock"></i></a>
                                                                <a href="administrators.php?do=dact-administrator&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="administrators.php?do=act-administrator&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="administrators.php?do=del-administrator&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php endif?>
                                                            </td>
                                                            <td><?= $name; ?></td>
                                                            <td><?= $row['fname']." ".$row['lname']; ?></td>
                                                            <td><?= $row['email']."<br>".$row['phone']; ?></td>
                                                            <td><img src="uploads/images/users/admin/<?= $row['image']; ?>" alt="Admin Avater" class="img-fluid rounded-circle" width="40"></td>
                                                            <td><?php echo $dc; ?></td>
                                                            <td>
                                                                <?php
                                                                if(empty($du)){
                                                                    echo $du;
                                                                }else{
                                                                    echo $duFormatted;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <i class="fa fa-circle text-<?= formatStatus($row['status']); ?>"></i>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <?php include("includes/foot.php"); ?>
            <?php include("includes/footer.php"); ?>
