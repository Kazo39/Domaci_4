<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    if(!isset($_POST['id']) || (!isset($_POST['new_name']) || $_POST['new_name'] == '')){
        header("location:./classes.php?msg=error");
        exit;
    }else{
        $id = $_POST['id'];
        $name = $_POST['new_name'];
    }

    $sql = "UPDATE vehicle_class SET name = '$name' WHERE id = $id";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        header("location:./classes.php?msg=success");
        exit;
    }else{
        header("location://classes.php?msg=error");
        exit;
    }
    

?>

