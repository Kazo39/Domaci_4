<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    if(!isset($_GET['total_price']) || !isset($_GET['date_from']) || !isset($_GET['date_up_to']) || !isset($_GET['res_id']) || !isset($_GET['v_id']) ){
        echo json_encode(["message" => "fail"]);
        exit;
    }else{
        $total_price = $_GET['total_price'];
        $date_from = $_GET['date_from'];
        $date_up_to = $_GET['date_up_to'];
        $res_id = $_GET['res_id'];
        $v_id = $_GET['v_id'];
        $client_id = $_SESSION['client']['id'];
    }

    $sql = "SELECT  
                date_from, 
                date_up_to 
            FROM reservations WHERE vehicle_id = $v_id AND is_active = 1 AND id != $res_id ";
    $res = mysqli_query($db_conn,$sql);
    
    
    
    if(!$res){
        echo json_encode(["message" => "fail"]);
        exit;
    }else{
        $user_day_from = date_format(date_create($date_from),"d");
        $user_mounth_from = date_format(date_create($date_from),"m");
        $user_day_up_to = date_format(date_create($date_up_to),"d");
        $user_mounth_up_to = date_format(date_create($date_up_to),"m");
        $user_year_up_to = date_format(date_create($date_up_to),"Y");
        $user_year_from = date_format(date_create($date_from),"Y");
        
        $ind = false;
        
        while($row = mysqli_fetch_assoc($res)){
               

            $sql_day_from = date_format(date_create($row['date_from']),"d");
            $sql_mounth_from = date_format(date_create($row['date_from']),"m");
            $sql_day_up_to = date_format(date_create($row['date_up_to']),"d");
            $sql_mounth_up_to = date_format(date_create($row['date_up_to']),"m");
            $sql_year_up_to = date_format(date_create($row['date_up_to']),"Y");
            $sql_year_from = date_format(date_create($row['date_from']),"Y");
           
            $result = validateReservation(
                $sql_day_from,
                $sql_day_up_to,
                $user_day_from, 
                $user_day_up_to,
                $user_mounth_from,
                $user_mounth_up_to,
                $sql_mounth_from,
                $sql_mounth_up_to,
                $user_year_from,
                $user_year_up_to,
                $sql_year_from,
                $sql_year_up_to         
            );
            
            if($result == "Busy") $ind = true;
        }
        if($ind == false){
            $sql = "UPDATE reservations SET
                        date_from = '$date_from', date_up_to = '$date_up_to', price = $total_price, vehicle_id = $v_id
                    WHERE id = $res_id";
            $res = mysqli_query($db_conn, $sql);
            
            if($res){
                echo json_encode(["message" => "Empty"]);
                exit;
            }else{
                echo json_encode(["message" => "Error"]);
                exit;
            }
        }else{
            echo json_encode(["message" => "Busy"]);
            exit;
        }
    }

?>