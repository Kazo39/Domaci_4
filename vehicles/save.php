<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    isAdmin();




    $manufacturer_id_for_query = null;
    $model_id_for_query = null;
    $res_begin = mysqli_query($db_conn, "BEGIN;");
    if(isset($_POST['all_manufacturers'])){
        $manufacturer_id = $_POST['all_manufacturers'];
        $manufacturer_id_for_query = $manufacturer_id;
    }else if(isset($_POST['new_manufacturer'])){
        $manufacturer_name = $_POST['new_manufacturer'];      
        $sql = "INSERT INTO vehicle_manufacturer(name) VALUE('$manufacturer_name')";
        $res = mysqli_query($db_conn, $sql);
        $manufacturer_id_for_query = mysqli_insert_id($db_conn);
        if(!$res){
            $res_begin = mysqli_query($db_conn, "ROLLBACK;");
            exit;
        }
    }else{
        $res_begin = mysqli_query($db_conn, "ROLLBACK;");
        exit('Nisu svi podaci uneseni...');
    }

    if(isset($_POST['all_models'])){
        $model_id = $_POST['all_models'];
        $model_id_for_query = $model_id;
    }else if(isset($_POST['new_vehicle_model']) || isset($_POST['new_model'])){
        if($_POST['vehicle_manufacturer'] == 'new_vehicle_manufacturer'){
            $model_name = $_POST['new_vehicle_model'];
        }else{
            $model_name = $_POST['new_model'];
        }        
        $sql = "INSERT INTO vehicle_model(name, manufacturer_id) VALUE('$model_name', $manufacturer_id_for_query)";
        $res = mysqli_query($db_conn, $sql);
        $model_id_for_query = mysqli_insert_id($db_conn);
        if(!$res){
            $res_begin = mysqli_query($db_conn, "ROLLBACK;");
            exit;
        }
    }else{
        $res_begin = mysqli_query($db_conn, "ROLLBACK;");
        exit('Nisu svi podaci uneseni...');
    }

    if(isset($_POST['vehicle_class']) && isset($_POST['registry_number']) && isset($_POST['price_per_day']) && isset($_POST['year_realesed'])){
        $class_id = $_POST['vehicle_class'];
        $registry_number = $_POST['registry_number'];
        $price_per_day = $_POST['price_per_day'];
        $year_realesed = $_POST['year_realesed'];
    }else{
        $res_begin = mysqli_query($db_conn, "ROLLBACK;");
        exit('Nisu uneseni svi podaci...');
    }

    $sql = "INSERT INTO
                vehicles(year_released, price_per_day, registry_number, vehicle_class_id, manufacturer_id, model_id)
            VALUES('$year_realesed', $price_per_day, '$registry_number', $class_id, $manufacturer_id_for_query, $model_id_for_query)";
    $res = mysqli_query($db_conn, $sql);
    

    if($res){
        $new_vehicle_id = mysqli_insert_id($db_conn);
        $upload_dir = "../uploads/";
        $allowed_extensions = ['JPG','PNG','jpg','png'];
        $error_attaching = false;

        if(isset($_FILES) && count($_FILES) > 0){
            foreach($_FILES['files']['name'] as $key => $image_name){
                $path = uploadImages($allowed_extensions,$upload_dir,$image_name,$_FILES['files']['tmp_name'][$key]);
                $sql = "INSERT INTO vehicle_images(path, vehicle_id) VALUES('$path', $new_vehicle_id)";
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
        header('location:./add_new_vehicle.php?msg=error');
    }
   
?>