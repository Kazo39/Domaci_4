<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    isAdmin();    
    $sql = "SELECT * FROM vehicle_manufacturer ORDER BY name";
    $res = mysqli_query($db_conn,$sql);

    if(!$res){
        echo json_encode([]);
        exit;
    }else{
        $manufacturers = [];
        while($row = mysqli_fetch_assoc($res)){
            $manufacturers[] = $row;     
        }
        echo json_encode($manufacturers);
        exit;
    }
    

