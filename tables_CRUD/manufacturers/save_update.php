<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    if(!isset($_POST['id']) || (!isset($_POST['new_name']) || $_POST['new_name'] == '')){
        header("location:manufacturers.php?msg=error");
        exit;
    }else{
        $id = $_POST['id'];
        $name = $_POST['new_name'];
    }

    $sql = "UPDATE vehicle_manufacturer SET name = '$name' WHERE id = $id";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        header("location:manufacturers.php?msg=success");
        exit;
    }else{
        header("location:manufacturers.php?msg=error");
        exit;
    }
    

?>

