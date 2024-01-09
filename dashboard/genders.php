<?php 
include("includes/config.php");

define("TITLE", "Managing Genders");
define("HEADER", "Managing Genders");
define("BREADCRUMB", "genders");

//page level scripts
$pageURL = "genders.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-gender'){
      $cardTitle = "Add Gender";
  }
  if($_GET['do'] == 'edit-gender'){
      if(isset($_GET['do'])) { $id = $_GET['id']; }
      $genderName = getDBcol('genders',$id);
      $cardTitle = "Edit Gender <small class='bg-dark text-white rounded-lg px-2 py-1'>$genderName</small>";
  }
}




//logics
//add
if(isset($_POST['addGender'])){
//    collection and scrutiny of data from form
    $genderName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['genderName'])));
    
//    validating the data
    if(empty($genderName)){
        array_push($errs, $genderNameError = "Please enter a gender name");
    }
    
//    pevent duplicate data in database table
    $checkGender = mysqli_query($conStr, "SELECT * FROM genders WHERE name='$genderName'");
    if(mysqli_num_rows($checkGender) > 0){
                array_push($errs, $genderExistError = "");
        $emsg = "Gender '$genderName' already exists. Please choose another name"; 
    }
    
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "INSERT INTO genders (name, dc) VALUES('$genderName', NOW())");
        if($query){
            $smsg = "Gender '$genderName' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//update

if(isset($_POST['updateGender'])){
//    collection and scrutiny of data from form
    $genderName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['genderName'])));
   $oldGenderName = getDBcol('genders',$id); 
//    validating the data
    if(empty($genderName)){
        array_push($errs, $genderNameError = "Please enter a gender name");
    }
    
//    pevent duplicate data in database table
    if($oldGenderName == $genderName){
                array_push($errs, $genderExistError = "");
        $emsg = "Modification is required to continue";
    }
    $checkGender = mysqli_query($conStr, "SELECT * FROM genders WHERE name='$genderName' AND id<>$id");
    if(mysqli_num_rows($checkGender) > 0){
                array_push($errs, $genderExistError = "");
        $emsg = "Gender '$GenderName' already exists. Please choose another name"; 
    }
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE genders SET name='$genderName', du=NOW()    WHERE id=$id");
        if($query){ 
            $smsg = "Gender '$oldGenderName' updated to '$genderName' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage gender
if(isset($_GET['do'])){
    if(isset($_GET['id'])){ 
        $id = $_GET['id']; 
        $genderName = getDBcol('genders',$id);
    }
    $do = $_GET['do'];
    
     
    
    if($do == 'edit-gender'){}
    if($do == 'dact-gender'){
        if(changeStatus('genders', $id, 'inactive') == 'ok'){
            $smsg = "Gender deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-gender'){
        if(changeStatus('genders', $id, 'active') == 'ok'){
            $smsg = "Gender '$genderName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'del-gender'){
        $delItem = true;
        $itemType = 'gender';
        $item   = $genderName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('genders', $id) == 'ok'){
                $smsg = "Gender '$genderName' deleted successfully";
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
                                        <a href="genders.php?do=add-gender&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="genders.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="genders.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="genders.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-gender'): ?>
                                                    <div id="add-gender">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Gender Name *" class="form-control" name="genderName" value="<?php if(isset($_POST['genderName'])) {echo $_POST['genderName']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($genderNameError)){echo $genderNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addGender" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-gender'): ?>
                                                    <div id="edit-gender">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Gender Name *" class="form-control" name="genderName" value="<?php if(isset($_POST['genderName'])) {echo $_POST['genderName']; } else{ echo $genderName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($genderNameError)){echo $genderNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateGender" class="btn btn btn-sm btn-primary text-white">Update</button>
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
                                                            <th>Gender</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM genders");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="genders.php?do=edit-gender&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                                <a href="genders.php?do=dact-gender&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="genders.php?do=act-gender&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="genders.php?do=del-gender&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php endif?>
                                                            </td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?= $dc; ?></td>
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
