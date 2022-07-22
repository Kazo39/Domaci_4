<?php

    session_start();
    include '../connect.php';
    include '../functions.php';

    $email = readInput($_POST,'email');
    $password = readInput($_POST,'password');
   

    $sql = "SELECT * FROM clients WHERE email = '$email' AND password = md5('$password')";
    
    $res = mysqli_query($db_conn,$sql);
    if(mysqli_num_rows($res) > 0){
        $_SESSION['login'] = true;
        $_SESSION['client'] =  mysqli_fetch_assoc($res);
        
        header("location:../../index.php");
        exit;
    }else{
        header('location:../../home/login.php?err=wrongCredentials');
        exit;
    }



?>