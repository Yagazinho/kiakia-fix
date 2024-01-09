<?php 
include("includes/config.php");

define("TITLE", "Managing Roles");
define("HEADER", "Managing Roles");
define("BREADCRUMB", "roles");

//page level scripts
$pageURL = "roles.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-role'){
      $cardTitle = "Add Role";
  }
  if($_GET['do'] == 'edit-role'){
      if(isset($_GET['do'])) { $id = $_GET['id']; }
      $roleName = getDBcol('roles',$id);
      $cardTitle = "Edit Role <small class='bg-dark text-white rounded-lg px-2 py-1'>$roleName</small>";
  }
}

//logics
//add
if(isset($_POST['addRole'])){
//    collection and scrutiny of data from form
    $roleName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['roleName'])));
    
//    validating the data
    if(empty($roleName)){
        array_push($errs, $roleNameError = "Please enter a role name");
    }
    
//    pevent duplicate data in database table
    $checkRole = mysqli_query($conStr, "SELECT * FROM roles WHERE name='$roleName'");
    if(mysqli_num_rows($checkRole) > 0){
                array_push($errs, $roleExistError = "");
        $emsg = "Role '$roleName' already exists. Please choose another name"; 
    }
    
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "INSERT INTO roles (name, dc) VALUES('$roleName', NOW())");
        if($query){
            $smsg = "Role '$roleName' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//update

if(isset($_POST['updateRole'])){
//    collection and scrutiny of data from form
    $roleName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['roleName'])));
   $oldRoleName = getDBcol('roles',$id); 
//    validating the data
    if(empty($roleName)){
        array_push($errs, $roleNameError = "Please enter a role name");
    }
    
//    pevent duplicate data in database table
    if($oldRoleName == $roleName){
                array_push($errs, $roleExistError = "");
        $emsg = "Modification is required to continue";
    }
    $checkRole = mysqli_query($conStr, "SELECT * FROM roles WHERE name='$roleName' AND id<>$id");
    if(mysqli_num_rows($checkRole) > 0){
                array_push($errs, $roleExistError = "");
        $emsg = "Role '$RoleName' already exists. Please choose another name"; 
    }
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE roles SET name='$roleName', du=NOW()    WHERE id=$id");
        if($query){ 
            $smsg = "Role '$oldRoleName' updated to '$roleName' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage role
if(isset($_GET['do'])){
    if(isset($_GET['id'])){ 
        $id = $_GET['id']; 
        $roleName = getDBcol('roles',$id);
    }
    $do = $_GET['do'];
     
    
    if($do == 'edit-role'){}
    if($do == 'dact-role'){
        if(changeStatus('roles', $id, 'inactive') == 'ok'){
            $smsg = "Role deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-role'){
        if(changeStatus('roles', $id, 'active') == 'ok'){
            $smsg = "Role '$roleName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'del-role'){
        $delItem = true;
        $itemType = 'role';
        $item   = $roleName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('roles', $id) == 'ok'){
                $smsg = "Role '$roleName' deleted successfully";
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
                                        <a href="roles.php?do=add-role&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="roles.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="roles.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="roles.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-role'): ?>
                                                    <div id="add-role">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Role Name *" class="form-control" name="roleName" value="<?php if(isset($_POST['roleName'])) {echo $_POST['roleName']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($roleNameError)){echo $roleNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addRole" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-role'): ?>
                                                    <div id="edit-role">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Role Name *" class="form-control" name="roleName" value="<?php if(isset($_POST['roleName'])) {echo $_POST['roleName']; } else{ echo $roleName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($roleNameError)){echo $roleNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateRole" class="btn btn btn-sm btn-primary text-white">Update</button>
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
                                                            <th>Role</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM roles");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="roles.php?do=edit-role&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                                <a href="roles.php?do=dact-role&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="roles.php?do=act-role&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="roles.php?do=del-role&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
