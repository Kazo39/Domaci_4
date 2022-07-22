<?php

    include "../backend/connect.php";
    include "../backend/functions.php";
    session_start();
    authorize();
    if(isset($_GET['reservation_id'])){
    $reservation_id = $_GET['reservation_id'];
    }else{
        echo json_encode([]);
        exit;
    }
    
    $cliend_id = $_SESSION['client']['id'];
    $sql = "UPDATE reservations SET is_active = false WHERE id = $reservation_id AND client_id = $cliend_id";
    $res = mysqli_query($db_conn,$sql);
    

    if(!$res){
        echo json_encode(["status" => "fail"]);
        exit;
    }
    echo json_encode([]);
    exit;


?>