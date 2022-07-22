<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    isAdmin();

    if(isset($_GET['image_path'])){
        $image_path = $_GET['image_path'];
    }else{
        header("location:./vehicles.php?msg=err");
        exit;
    }
    $id = $_SESSION['vehicle_id'];
    $registry_number = $_SESSION['registry_number'];
    $res_begin = mysqli_query($db_conn, "BEGIN;");
    $sql = "DELETE FROM vehicle_images WHERE path = '$image_path'";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        if(!unlink($image_path)){
            $res_begin = mysqli_query($db_conn, "ROLLBACK;");
            header("location:./vehicles.php?msg=err");
            exit;
        }else{
            $res_begin = mysqli_query($db_conn, "COMMIT;");           
            header("location:./edit.php?vehicle_id=$id&registry_number=$registry_number");
            exit;
        }
    }else{
            $res_begin = mysqli_query($db_conn, "ROLLBACK;");
            header("location:./vehicles.php?msg=err");
            exit;
    }
?>