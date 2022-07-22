<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    if(!isset($_GET['vehicle_id'])){
        echo json_encode([]);
        exit;
    }else{
        $vehicle_id = $_GET['vehicle_id'];
    }
    $sql = "SELECT
                v.id,
                v.registry_number,
                v.year_released,
                v_c.name AS class_name,
                v_m.name AS manufacturer_name,
                v_model.name AS model_name,
                v_model.id AS model_id,
                v_i.path,
                v.price_per_day
                FROM vehicles v
                LEFT JOIN vehicle_class v_c ON v.vehicle_class_id = v_c.id
                LEFT JOIN vehicle_images v_i ON v_i.vehicle_id = v.id
                LEFT JOIN vehicle_manufacturer v_m ON v_m.id = v.manufacturer_id 
                LEFT JOIN vehicle_model v_model ON v_model.manufacturer_id = v_m.id AND v_model.id = v.model_id
            WHERE v.id = $vehicle_id;";
    $res = mysqli_query($db_conn,$sql);

    if(!$res){
        echo json_encode([]);
        exit;
    }else{
        $vehicle = [];
        while($row = mysqli_fetch_assoc($res)){
            $manufacturers[] = $row;     
        }
        echo json_encode($manufacturers);
        exit;
    }
    