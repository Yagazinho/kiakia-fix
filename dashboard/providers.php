<?php 
include("includes/config.php");

define("TITLE", "Managing Providers");
define("HEADER", "Managing Providers");
define("BREADCRUMB", "providers");

//page level scripts
$pageURL = "providers.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-provider'){
      $cardTitle = "Add Provider";
  }
    if($_GET['do'] == 'edit-provider' || $_GET['do'] == 'edit-username' || $_GET['do'] == 'edit-email' || $_GET['do'] == 'update-image' || $_GET['do'] == 'update-pwd'){
        $do = $_GET['do'];
        if($do == 'edit-provider'){ $title = 'Basic Info'; } 
        elseif($do == 'edit-username'){ $title = 'Username'; }
        elseif($do == 'edit-email'){ $title = 'Email'; }
        elseif($do == 'update-image'){ $title = 'Image'; }
        elseif($do == 'update-pwd'){ $title = 'Password'; }
        if(isset($_GET['do'])) { $id = $_GET['id']; }
        $userName = getDBcol('providers',$id, 'username');
        $fname = getDBcol('providers',$id, 'fname');
        $lname = getDBcol('providers',$id, 'lname');
        $email = getDBcol('providers',$id, 'email');
        $phone = getDBcol('providers',$id, 'phone');
        $image = getDBcol('providers',$id, 'image');
        $nin = getDBcol('providers',$id, 'nin');
        $gID = getDBcol('providers',$id, 'gID');
        $cardTitle = "Edit $title <small class='bg-dark text-white rounded-lg px-2 py-1'>$userName - $gID</small>";
    }
}

//logics
//add
if(isset($_POST['addProvider'])){
//    collection and scrutiny of data from form 
    $userName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['userName'])));
    $fname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['fname'])));
    $lname  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['lname'])));
    $phone  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['phone'])));
    $email  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['email'])));
    $pwd  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd'])));
    $pwd2  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['pwd2'])));
    
    $nin = trim(intval($_POST['nin']));
    
    //validating the data
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
    if(empty($pwd)){
        array_push($errs, $pwdError = "Please enter a value");
    }
    if(empty($pwd2)){
        array_push($errs, $pwd2Error = "Please enter a value");
    }
    
    if($nin == 0){
        array_push($errs, $ninError = "Please select a value");
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
        $uStr = 'kfa-';
        $gID  = $uStr.mt_rand(000,999);
        $cryptedPwd = md5($pwd2);
        $query  = mysqli_query($conStr, "INSERT INTO providers(gID, username, fname, lname, email, phone, nin, pwd, dc) VALUES('$gID', '$userName', '$fname', '$lname', '$email', '$phone', $nin, '$cryptedPwd', NOW())");
        if($query){
            $smsg = "Provider '$userName' saved successfully";
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
    $ninFrm = trim(intval($_POST['nin']));  
    
    //validating the data
    if(empty($fnameFrm)){
        array_push($errs, $fnameError = "Please enter a value");
    }
    if(empty($lnameFrm)){
        array_push($errs, $lnameError = "Please enter a value");
    }
    if($ninFrm == 0){
        array_push($errs, $ninError = "Please select a value");
    }
    
    //proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE providers SET fname='$fnameFrm', lname='$lnameFrm', nin='$ninFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Provider '$userName' Basic info updated successfully";
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
        $checkUserName = mysqli_query($conStr, "SELECT * FROM providers WHERE username='$userNameFrm'");
        if(mysqli_num_rows($checkUserName) > 0){
            array_push($errs, $userExistError = "");
            $emsg = "User with username '$userNameFrm' already exists. Please choose another name"; 
        }
    }
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE providers SET username='$userNameFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Provider '$userName' updated to '$userNameFrm' successfully";
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
        $checkUserEmail = mysqli_query($conStr, "SELECT * FROM providers WHERE email='$emailFrm'");
        if(mysqli_num_rows($checkUserEmail) > 0){
            array_push($errs, $emailExistError = "");
            $emsg = "User with email '$emailFrm' already exists. Please choose another name"; 
        }
    }
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE providers SET email='$emailFrm', du=NOW() WHERE id=$id");
        if($query){ 
            $smsg = "Provider '$email' updated to '$emailFrm' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

if(isset($_POST['updateImage'])){
    $uploadPath = "uploads/images/users/provider/";
    #collection and scrutiny of data from form
    $userImage = $_FILES['userImage']['name'];
    
    #get file extension
    $fileNameArr = explode(".",$userImage);
    $ext = strtolower(".".end($fileNameArr));
    $allowedExts = ['.jpg','.png'];
    if(!in_array($ext, $allowedExts)){
        array_push($errs, $userImageError = "file format '$ext' not supported");
    }
    
    #renamin the image file with custom name
    $newImgName = strtolower($gID.$ext);
    
    #proceed with data storage when there is no error
    if(count($errs) == 0){
        $possibleFile1 = $gID.'.jpg';
        $possibleFile2 = $gID.'.png';
        $query  = mysqli_query($conStr, "UPDATE providers SET image='$newImgName', du=NOW() WHERE id=$id");
        if($query){
            #check if file exists and remove it
            if(file_exists($uploadPath.$possibleFile1)){ unlink($uploadPath.$possibleFile1); }
            if(file_exists($uploadPath.$possibleFile1)){ unlink($uploadPath.$possibleFile1); }
            
            #move file into desired directory
            if(move_uploaded_file($_FILES['userImage']['tmp_name'], $uploadPath.$newImgName)){
                $smsg = "Provider profile image updated successfully";    
            }
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage provider
if(isset($_GET['do']) && isset($_GET['id'])){
    $id = $_GET['id']; 
    $userName = getDBcol('providers',$id,'username');
    $do = $_GET['do'];
    
    if($do == 'edit-provider'){}
    if($do == 'dact-provider'){
        if(changeStatus('providers', $id, 'inactive') == 'ok'){
            $smsg = "Provider '$userName' deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-provider'){
        if(changeStatus('providers', $id, 'active') == 'ok'){
            $smsg = "Provider '$userName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }

    if($do == 'del-provider'){
        $delItem = true;
        $itemType = 'Provider';
        $item   = $userName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('Providers', $id) == 'ok'){
                $smsg = "Provider '$userName' deleted successfully";
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
                                        <a href="providers.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="providers.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-body text-dark">
                                                <h6 class="card-title mb-5">Manage All</h6>
                                                <?php include("includes/del-alert.php"); ?>
                                                <table class="table datatable table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Action</th>
                                                            <th>Username - (ID | NIN | Gender)</th>
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
                                                        $query = mysqli_query($conStr, "SELECT * FROM providers");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            $du  = $row['du'];
                                                            $genderName = getDBcol('genders',$row['gender']);
                                                            
                                                            $name = $row['username']." - (".$row['gID']." | ".$row['nin']." | ".$genderName.")"; 
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="providers.php?do=edit-provider&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Basic"><i class="fa fa-edit"></i></a>
                                                                <a href="providers.php?do=edit-username&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Username"><i class="fa fa-id-card-o"></i></a>
                                                                <a href="providers.php?do=edit-email&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit Email"><i class="fa fa-envelope"></i></a>
                                                                <a href="providers.php?do=update-image&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-info" title="Update Image"><i class="fa fa-photo"></i></a>
                                                                <a href="providers.php?do=update-pwd&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-dark" title="Update Password"><i class="fa fa-lock"></i></a>
                                                                <a href="providers.php?do=dact-provider&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="providers.php?do=act-provider&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="providers.php?do=del-provider&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php endif?>
                                                            </td>
                                                            <td><?= $name; ?></td>
                                                            <td><?= $row['fname']." ".$row['lname']; ?></td>
                                                            <td><?= $row['email']."<br>".$row['phone']; ?></td>
                                                            <td><img src="uploads/images/users/provider/<?= $row['image']; ?>" alt="Admin Avater" class="img-fluid rounded-circle" width="40"></td>
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
