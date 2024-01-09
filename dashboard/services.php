<?php 
include("includes/config.php");

define("TITLE", "Managing Services");
define("HEADER", "Managing Services");
define("BREADCRUMB", "services");

//page level scripts
$pageURL = "services.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-service'){
      $cardTitle = "Add Service";
  }
  if($_GET['do'] == 'edit-service'){
      if(isset($_GET['do'])) { $id = $_GET['id']; }
      $serviceName = getDBcol('services',$id);
      $cardTitle = "Edit Service <small class='bg-dark text-white rounded-lg px-2 py-1'>$serviceName</small>";
  }
}




//logics
//add
if(isset($_POST['addService'])){
//    collection and scrutiny of data from form
    $serviceName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['serviceName'])));
    
//    validating the data
    if(empty($serviceName)){
        array_push($errs, $serviceNameError = "Please enter a service name");
    }
    
//    pevent duplicate data in database table
    $checkService = mysqli_query($conStr, "SELECT * FROM services WHERE name='$serviceName'");
    if(mysqli_num_rows($checkService) > 0){
                array_push($errs, $serviceExistError = "");
        $emsg = "Service '$serviceName' already exists. Please choose another name"; 
    }
    
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "INSERT INTO services (name, dc) VALUES('$serviceName', NOW())");
        if($query){
            $smsg = "Service '$serviceName' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//update

if(isset($_POST['updateService'])){
//    collection and scrutiny of data from form
    $serviceName  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['serviceName'])));
   $oldServiceName = getDBcol('services',$id); 
//    validating the data
    if(empty($serviceName)){
        array_push($errs, $serviceNameError = "Please enter a service name");
    }
    
//    pevent duplicate data in database table
    if($oldServiceName == $serviceName){
                array_push($errs, $serviceExistError = "");
        $emsg = "Modification is required to continue";
    }
    $checkService = mysqli_query($conStr, "SELECT * FROM services WHERE name='$serviceName' AND id<>$id");
    if(mysqli_num_rows($checkService) > 0){
                array_push($errs, $serviceExistError = "");
        $emsg = "Service '$ServiceName' already exists. Please choose another name"; 
    }
//    proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "UPDATE services SET name='$serviceName', du=NOW()    WHERE id=$id");
        if($query){ 
            $smsg = "Service '$oldServiceName' updated to '$serviceName' successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage service
if(isset($_GET['do'])){
    if(isset($_GET['id'])){ 
        $id = $_GET['id']; 
        $serviceName = getDBcol('services',$id);
    }
    $do = $_GET['do'];
    
     
    
    if($do == 'edit-service'){}
    if($do == 'dact-service'){
        if(changeStatus('services', $id, 'inactive') == 'ok'){
            $smsg = "Service deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-service'){
        if(changeStatus('services', $id, 'active') == 'ok'){
            $smsg = "Service '$serviceName' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'del-service'){
        $delItem = true;
        $itemType = 'service';
        $item   = $serviceName;
        if(isset($_POST['doDlt'])){
            if(deleteRow('services', $id) == 'ok'){
                $smsg = "Service '$serviceName' deleted successfully";
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
                                        <a href="services.php?do=add-service&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="services.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="services.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="services.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-service'): ?>
                                                    <div id="add-service">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Service Name *" class="form-control" name="serviceName" value="<?php if(isset($_POST['serviceName'])) {echo $_POST['serviceName']; } ?>">
                                                                    <span class="text-danger"><?php if(isset($serviceNameError)){echo $serviceNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addService" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <?php endif ?>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'edit-service'): ?>
                                                    <div id="edit-service">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="Service Name *" class="form-control" name="serviceName" value="<?php if(isset($_POST['serviceName'])) {echo $_POST['serviceName']; } else{ echo $serviceName; } ?>">
                                                                    <span class="text-danger"><?php if(isset($serviceNameError)){echo $serviceNameError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="updateService" class="btn btn btn-sm btn-primary text-white">Update</button>
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
                                                            <th>Service</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM services");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="services.php?do=edit-service&id=<?php echo $row['id']; ?>&min=true" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                                <a href="services.php?do=dact-service&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="services.php?do=act-service&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="services.php?do=del-service&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
