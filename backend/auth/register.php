<?php
    session_start();
    include '../connect.php';
    include '../functions.php';

    $email = readInput($_POST,'email');
    $password = readInput($_POST,'password');
    $first_name = readInput($_POST,'first_name');
    $last_name = readInput($_POST,'last_name');
    $passport_number = readInput($_POST,'passport_number');
    $country_id = readInput($_POST, 'country');

    if(
        $email == false
        || $password == false 
        || $first_name == false 
        || $last_name == false 
        || $passport_number == false 
        || $country_id == false){
            header('location:../../home/register.php?err=nisu_unijeti_svi_podaci');
            exit;
    }

    $sql = "INSERT INTO
                clients(email,password,first_name,last_name,passport_number,country_id)
            VALUES('$email', md5('$password'), '$first_name', '$last_name', '$passport_number', $country_id)";
    
    $res = mysqli_query($db_conn,$sql);
    
    if($res){
        $_SESSION['login'] = true;
        $id = mysqli_insert_id($db_conn);
        $client = ["first_name" => $first_name, 
                    "last_name" => $last_name, 
                    "passport_number" => $passport_number, 
                    "id" => $id, 
                    "email" => $email, 
                    "country_id" => $country_id, 
                    "is_admin" => 0,
                    "password" => md5($password)];
        $_SESSION['client'] =  $client;
        header("location:../../index.php");
        exit;
    }else{
        header('location:../../home/register.php?err=ErrorOccurred');
        exit;
    }
?>