<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    if(!isset($_POST['first_name']) || $_POST['first_name'] == '' || 
            !isset($_POST['last_name']) || $_POST['last_name'] == '' ||
            !isset($_POST['passport_number']) || $_POST['passport_number'] == '' ||
            !isset($_POST['email']) || $_POST['email'] == '' ||
            !isset($_POST['country'])||
            !isset($_POST['old_password']) || $_POST['old_password'] == ''){
        header("location:./client.php?msg=nisu_unijeti_svi_podaci");
        exit;
    }else{
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $passport_number = $_POST['passport_number'];
        $country_id = $_POST['country'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $email = $_POST['email'];
        $id = $_SESSION['client']['id'];
    }

    if(md5($old_password) != $_SESSION['client']['password']){
        header("location:./client.php?msg=nije_tačna_lozinka");
        exit;
    }
    if($new_password != ''){
    $query = ", password = md5('$new_password')";
    }else{
        $query = "";
    }

    $sql = "UPDATE clients SET 
                first_name = '$first_name', 
                last_name = '$last_name', 
                passport_number = '$passport_number', 
                country_id = $country_id,
                email = '$email' $query
            WHERE id = $id";
    $res = mysqli_query($db_conn, $sql);

    if($res){
        $client = ["first_name" => $first_name, 
                    "last_name" => $last_name, 
                    "passport_number" => $passport_number, 
                    "id" => $id, 
                    "email" => $email, 
                    "country_id" => $country_id, 
                    "is_admin" => 0,
                    "password" => md5($old_password)];
        if($query != ''){
            $client['password'] = md5($new_password);
        }
        if($_SESSION['client']['is_admin'] == 1){
            $client['is_admin'] = 1;
        }

        $_SESSION['client'] =  $client;
        header("location:./client.php?msg=success");
        exit;
    }else{
        header("location:./client.php?msg=error");
        exit;
    }
    

?>

