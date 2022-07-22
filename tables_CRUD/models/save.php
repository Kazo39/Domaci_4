<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    if(!isset($_POST['name']) || !isset($_POST['manufacturer'])){
        header("location:models.php?msg=nisu_unijeti_svi_podaci");
        exit;
    }else{
        $name = $_POST['name'];
        $manufacturer_id = $_POST['manufacturer'];
    }

    $sql = "INSERT INTO vehicle_model(name, manufacturer_id) VALUES('$name', $manufacturer_id)";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        header("location:models.php?msg=success");
        exit;
    }else{
        header("location:models.php?msg=fail");
        exit;
    }
    

?>

