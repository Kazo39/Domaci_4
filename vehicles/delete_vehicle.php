<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    isAdmin();
    if(isset($_GET['vehicle_id']) && isset($_GET['model_id'])){
    $vehicle_id = $_GET['vehicle_id'];
    $model_id = $_GET['model_id'];
    }else{
        echo json_encode([]);
        exit;
    }
    
    $res_begin = mysqli_query($db_conn, "BEGIN;");
    $sql = "SELECT * FROM vehicle_images WHERE vehicle_id = $vehicle_id";
    $res = mysqli_query($db_conn, $sql);
    
    if($res){     
        $sql_images = "DELETE FROM vehicle_images WHERE vehicle_id = $vehicle_id";
        $res_images = mysqli_query($db_conn, $sql_images);

        $sql_vehicles = "DELETE FROM vehicles WHERE id = $vehicle_id";
        $res_vehicles = mysqli_query($db_conn, $sql_vehicles);
        
        if($res_images && $res_vehicles){
            while($row = mysqli_fetch_assoc($res)){
                if(!unlink($row['path'])){
                    $res_begin = mysqli_query($db_conn, "ROLLBACK;");
                    echo json_encode(["message" => "error"]);
                    exit;
                }
            }
            $res_begin = mysqli_query($db_conn, "COMMIT;");           
            echo json_encode(["message" => "success"]);
            exit;
        }else{
            $res_begin = mysqli_query($db_conn, "ROLLBACK;");
            echo json_encode(["message" => "error"]);
            exit;
        }       
    }else{
        $res_begin = mysqli_query($db_conn, "ROLLBACK;");
        echo json_encode(["message" => "error"]);
        exit; 
    }


?>