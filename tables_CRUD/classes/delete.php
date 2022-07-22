<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    if(!isset($_GET['id'])){
        echo json_encode(["message" => "error"]);
        exit;
    }else{
        $id = $_GET['id'];
    }

    $sql = "DELETE FROM vehicle_class WHERE id = $id";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        echo json_encode(["message" => "success"]);
        exit;
    }else{
        echo json_encode(["message" => "fail"]);
        exit;
    }
    

?>

