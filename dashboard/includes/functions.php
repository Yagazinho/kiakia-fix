<?php

//custom functions here
function formatStatus($status){
    if($status == 'active'){
        $color = 'success';
    }
    elseif($status == 'pending'){
        $color = 'secondary';
    }
    elseif($status == 'inactive'){
        $color = 'danger';
    }
    return $color;
}

function changeStatus($tbl, $id, $newStatus){
    global $conStr;
    $query = mysqli_query($conStr, "UPDATE $tbl SET status='$newStatus', du=NOW() WHERE id=$id");
    if($query) { return 'ok'; }else{ return 'fail';} 
}

function deleteRow($tbl, $id){
    global $conStr;
    $query = mysqli_query($conStr, "DELETE FROM $tbl WHERE id=$id");
    if($query) { return 'ok'; }else{ return 'fail';} 
}

function getDBcol($tbl, $id, $col = 'name'){
    global $conStr;
    $query = mysqli_query($conStr, "SELECT $col FROM $tbl WHERE id=$id");
    $row = mysqli_fetch_array($query);
    return $row[$col];
}

function countRows($tbl, $where=null){
    global $conStr;
    if ($where != null){
        $query = mysqli_query($conStr, "SELECT * FROM $tbl WHERE $where");
    }
    else{
        $query = mysqli_query($conStr, "SELECT * FROM $tbl");
    }
    return mysqli_num_rows($query);
}

function generateNIN($length){
    $nin =  '';
    for($i = 0; $i < $length; $i++){
        $nin .= mt_rand(0,9); 
    }
    return $nin;
}

?>
