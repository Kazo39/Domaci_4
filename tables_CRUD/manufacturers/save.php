<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    if(!isset($_POST['name']) || $_POST['name'] == ''){
        header("location:manufacturers.php?msg=nisu_unijeti_svi_podaci");
        exit;
    }else{
        $name = $_POST['name'];
    }

    $sql = "INSERT INTO vehicle_manufacturer(name) VALUES('$name')";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        header("location:manufacturers.php?msg=success");
        exit;
    }else{
        header("location:manufacturers.php?msg=error");
        exit;
    }
    

?>

