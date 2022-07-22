<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    if(isset($_GET['manufacturer_id'])){
        $manufacturer_id = $_GET['manufacturer_id'];
    }else{
        echo json_encode([]);
        exit;
    }
    $sql = "SELECT * FROM vehicle_model WHERE manufacturer_id = $manufacturer_id ORDER BY name";
    $res = mysqli_query($db_conn,$sql);
    if(!$res){
        echo json_encode([]);
        exit;
    }else{
        $models = [];
        while($row = mysqli_fetch_assoc($res)){
            $models[] = $row;     
        }
        echo json_encode($models);
        exit;
    }
    

