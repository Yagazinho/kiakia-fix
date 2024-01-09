<?php 
include("includes/config.php");

define("TITLE", "Managing States");
define("HEADER", "Managing States");
define("BREADCRUMB", "states");

//page level scripts
$pageURL = "states.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-state'){
      $cardTitle = "Add State";
  }
  if($_GET['do'] == 'edit-state'){
      if(isset($_GET['do'])) { $id = $_GET['id']; }
      $stateName = getDBcol('states',$id);
      $stateCapital = getDBcol('states',$id, 'capital');
      $cardTitle = "Edit State <small class='bg-dark text-white rounded-lg px-2 py-1'>$stateName</small>";
  }
}




//logics
//add
if(isset($_POST['addState'])){
//    collection and scrutiny of data from form
    $stateName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['stateName'])));
    $capital  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['capital'])));
    
//    validating the data
    if(empty($stateName)){
        array_push($errs, $stateNameError = "Please enter a state name");
    }
    
    if(empty($capital)){
        array_push($errs, $capitalError = "Please enter a capital");
    } 
    
//    pevent duplicate data in database table
    $checkState = mysqli_query($conStr, "SELECT * FROM states WHERE name='$stateName'");
    if(mysqli_num_rows($checkState) > 0){
                array_push($errs, $stateExistError = "");
        $emsg = "State '$stateName' already exists. Please choose another name"; 
    }
    
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "INSERT INTO states (name, capital, dc) VALUES('$stateName', '$capital', NOW())");
        if($query){
            $smsg = "State '$stateName' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//update

if(isset($_POST['updateState'])){
//    collection and scrutiny of data from form
    $stateName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['stateName'])));
    $capital  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['capital'])));
   $oldStateName = getDBcol('states',$id); 
   $oldStateCapital = getDBcol('states',$id, 'capital'); 
//    validating the data
    if(empty($stateName)){
        array_push($errs, $stateNameError = "Please enter a state name");
    }
    if(empty($capital)){
        array_push($errs, $capitalError = "Please enter a capital");
    }
//    pevent duplicate data in database table
    if($oldStateName == $stateName){
                array_push($errs, $stateExistError = "");
        $emsg = "Modification is required to continue";
    }
    $checkState = mysqli_query($conStr, "SELECT * FROM states WHERE name='$stateName' AND id<>$id");
    if(mysqli_num_rows($checkState) > 0){
                array_push($errs, $stateExistError = "");
        $emsg = "State '$StateName' already exists. Please choose another name"; 
    }
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        if($capital == $oldStateCapital){
        $query  = mysqli_query($conStr, "UPDATE states SET name='$stateName', du=NOW()    WHERE id=$id");
        }
        else{
        $query  = mysqli_query($conStr, "UPDATE states SET name='$stateName', capital='$capital', du=NOW()    WHERE id=$id");
            
        }
        if($query){ 
            if($capital == $oldStateCapital){ 
            $smsg = "State '$oldStateName' updated to '$stateName' successfully";
            }
            else{
            $smsg = "State '$oldStateName ($oldStateCapital)' updated to '$stateName ($capital)' successfully";
            }
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage state
if(isset($_GET['do'])){
    if(isset($_GET['id'])){ 
        $id = $_GET['id']; 
        $stateName = getDBcol('states',$id);
    }
    $do = $_GET['do'];
    
     
    
    if($do == 'edit-state'){}
    if($do == 'dact-state'){
        if(changeStatus('states', $id, 'inactive') == 'ok'){
            $smsg = "State '$stateName' deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-state'){
        if(changeStatus('states', $id, 'active') == 'ok'){
            $smsg = "State '$stateName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'del-state'){
        $delItem = true;
        $itemType = 'state';
        $item   = $stateName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('states', $id) == 'ok'){
                $smsg = "State '$stateName' deleted successfully";
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
                                        <a href="states.php?do=add-state&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="states.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="states.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="states.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-state'): ?>
                                                    <div id="add-state">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="State Name *" class="form-control" name="stateName" value="<?php if(isset($_POST['stateName'])) {echo $_POST['stateName']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($stateNameError)){echo $stateNameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Capital *" class="form-control" name="capital" value="<?php if(isset($_POST['capital'])) {echo $_POST['capital']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($capitalError)){echo $capitalError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addState" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-state'): ?>
                                                    <div id="edit-state">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="State Name *" class="form-control" name="stateName" value="<?php if(isset($_POST['stateName'])) {echo $_POST['stateName']; } else{ echo $stateName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($stateNameError)){echo $stateNameError; } ?></span>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Capital*" class="form-control" name="capital" value="<?php if(isset($_POST['capital'])) {echo $_POST['capital']; } else{ echo $stateName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($capitalError)){echo $capitalError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateState" class="btn btn btn-sm btn-primary text-white">Update</button>
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
                                                            <th>State</th>
                                                            <th>Capital</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM states");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="states.php?do=edit-state&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                                <a href="states.php?do=dact-state&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="states.php?do=act-state&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="states.php?do=del-state&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php endif?>
                                                            </td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['capital']; ?></td>
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
