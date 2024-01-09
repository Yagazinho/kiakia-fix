<?php 
include("includes/config.php");

define("TITLE", "Managing NINs");
define("HEADER", "Managing NINs");
define("BREADCRUMB", "nins");

//page level scripts
$pageURL = "nins.php";

if(isset($_GET['do'])){
  if($_GET['do'] == 'add-nin'){
      $cardTitle = "Add NIN";
  }
  if($_GET['do'] == 'edit-nin'){
      if(isset($_GET['do'])) { $id = $_GET['id']; }
      $ninVal = getDBcol('nins',$id,'nin');
      $cardTitle = "Edit NIN <small class='bg-dark text-white rounded-lg px-2 py-1'>$ninVal</small>";
  }
}



//logics
//add
if(isset($_POST['addNIN'])){
//    collection and scrutiny of data from form
    $ninVal  = trim(stripslashes(mysqli_real_escape_string($conStr, $_POST['ninVal'])));
    
//    validating the data
    if(empty($ninVal)){
        array_push($errs, $ninValError = "Please enter a nin");
    }
    
    #prevent duplicate data in database table
    $checkNIN = mysqli_query($conStr, "SELECT * FROM nins WHERE nin='$ninVal'");
    if(mysqli_num_rows($checkNIN) > 0){
        array_push($errs, $ninExistError = "");
        $emsg = "NIN '$ninVal' already exists. Please choose another nin"; 
    }
    
    //proceed with data storage when there is no error
    if(count($errs) == 0){
        $query  = mysqli_query($conStr, "INSERT INTO nins (nin, dc) VALUES('$ninVal', NOW())");
        if($query){
            $smsg = "NIN '$ninVal' saved successfully";
        }
        else{
            $emsg = "Something went wrong, try again".mysqli_error($conStr);
        }
    }
}

//manage nin
if(isset($_GET['do'])){
    if(isset($_GET['id'])){ $id = $_GET['id']; $ninVal = getDBcol('nins',$id,'nin'); }
    $do = $_GET['do'];
     
    if($do == 'edit-nin'){}
    if($do == 'dact-nin'){
        if(changeStatus('nins', $id, 'inactive') == 'ok'){
            $smsg = "NIN deactivated successfully";
            header("Refresh: 5; URL=$pageURL");
        }
        else{
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'act-nin'){
        if(changeStatus('nins', $id, 'active') == 'ok'){
            $smsg = "NIN '$ninVal' activated successfully";
        }else{ 
            $emsg = "Something went wrong ";
        }
    }
    if($do == 'del-nin'){
        $delItem = true;
        $itemType = 'nin';
        $item   = $ninVal;
        if(isset($_POST['doDlt'])){
            if(deleteRow('nins', $id) == 'ok'){
                $smsg = "NIN '$ninVal' deleted successfully";
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
                                        <a href="nins.php?do=add-nin&min=true" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-plus"></i></a>
                                        <a href="nins.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                    <div class="btn-group float-right">
                                        <a href="nins.php" class="btn btn-dark btn-sm bg-dark"><i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if(isset($_GET['min']) && $_GET['min'] == 'true'): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-lg">
                                            <div class="card-header bg-white">
                                                <h6 class="card-title d-inline"><?php echo $cardTitle?></h6>
                                                <a href="nins.php" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                            </div>
                                            <div class="card-body text-dark">
                                                <form action="" method="post">
                                                    <p class="lead"><strong>NB:</strong> All fields marked with (<span class="text-danger">*</span>) must be filled accordignly</p>

                                                    <?php if(isset($_GET['do']) && $_GET['do'] == 'add-nin'): ?>
                                                    <div id="add-nin">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" placeholder="NIN Val *" class="form-control only-num" name="ninVal" value="<?= generateNIN(11) ?>" readonly>
                                                                    <span class="text-danger"><?php if(isset($ninValError)){echo $ninValError; } ?></span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="">
                                                            <button type="submit" name="addNIN" class="btn btn-sm btn-success text-white">Add</button>
                                                            <button type="reset" class="btn btn-sm bg-danger text-white">Cancel</button>
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
                                                            <th>NIN</th>
                                                            <th>Date Added</th>
                                                            <th>Date Updated</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query = mysqli_query($conStr, "SELECT * FROM nins");
                                                        while($row = mysqli_fetch_array($query)){
                                                            $dc = date("F jS, Y h:ia",strtotime($row['dc']));
                                                            $duFormatted = date("F jS, Y h:ia",strtotime($row['du']));
                                                            
                                                            $du  = $row['du'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td>
                                                                <?php if($row['status'] == 'active'): ?>
                                                                <a href="nins.php?do=dact-nin&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Deactivate"><i class="fa fa-times"></i></a>
                                                                <?php else:?>
                                                                <a href="nins.php?do=act-nin&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" title="Activate"><i class="fa fa-check"></i></a>
                                                                <a href="nins.php?do=del-nin&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php endif?>
                                                            </td>
                                                            <td><?php echo $row['nin']; ?></td>
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
