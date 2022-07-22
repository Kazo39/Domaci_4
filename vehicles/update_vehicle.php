<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    isAdmin();



    if(!isset($_POST['new_registry_number']) || 
            $_POST['new_registry_number'] == "" ||
            !isset($_POST['new_price_per_day']) ||
            $_POST['new_price_per_day'] == "" ||
            !isset($_POST['vehicle_class']) ){
        header('location:./vehicles.php?msg=nisu_uneseni_svi_podaci');
        exit;
    }else{
        $registry_number = $_POST['new_registry_number'];
        $price_per_day = $_POST['new_price_per_day'];
        $class_id = $_POST['vehicle_class'];
    }

    $id = $_SESSION['vehicle_id'];
    

    $res_begin = mysqli_query($db_conn, "BEGIN;");

    $sql = "UPDATE vehicles SET
                registry_number = '$registry_number', 
                price_per_day = $price_per_day, 
                vehicle_class_id = $class_id 
            WHERE id = $id";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        $upload_dir = "../uploads/";
        $allowed_extensions = ['JPG','PNG','jpg','png'];
        $error_attaching = false;

        if(isset($_FILES) && $_FILES['files']['name'][0] != ''){
            foreach($_FILES['files']['name'] as $key => $image_name){
                $path = uploadImages($allowed_extensions,$upload_dir,$image_name,$_FILES['files']['tmp_name'][$key]);
                $sql = "INSERT INTO vehicle_images(path, vehicle_id) VALUES('$path', $id)";
                $res = mysqli_query($db_conn,$sql);
               
                if(!$res){
                    $res_begin = mysqli_query($db_conn, "ROLLBACK;");
                    $error_attaching = true;
                    break;
                }
            }
        }
        if(!$error_attaching){
            $res_begin = mysqli_query($db_conn, "COMMIT;");
        }
        header('location:./vehicles.php?msg=success');
    }else{
        $res_begin = mysqli_query($db_conn,"ROLLBACK;");
        header('location:./vehicles.php?msg=error');
    }
    
    
?>