<?php

    function readInput($array, $key){
        if(isset($array[$key]) && $array[$key] != ""){
            return $array[$key];
        }
        return false;
    }

    function authorize(){
        if(!$_SESSION['login']){
            header("location:http://localhost/phpObuka/Domaci4/home/login.php");
            exit;
        }
    }
    

    function isAdmin(){
        if($_SESSION['login'] && $_SESSION['client']['is_admin'] == 0){
            header("location:location:http://localhost/phpObuka/Domaci4/index.php");
            exit;
        }
    }

    function uploadImages($allowed_extensions, $upload_dir,$image_name,$tmp_name){
        $new_imagename = uniqid();
        
        $image_extension = explode('.', $image_name);
        $image_extension = end($image_extension);
       
        if(!in_array($image_extension, $allowed_extensions)){
            exit("Nedozvoljen format slike...");
        }

        $new_imagename = $new_imagename.".".$image_extension;
        
        $tmp_path = $tmp_name;
        $new_image_path = $upload_dir.$new_imagename;
        if(!copy($tmp_path, $new_image_path)){
            exit("Greska pri upload-u slike...");
        }
        return $new_image_path;
    }

    function validateReservation(
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
        ){
        if($user_year_from == $user_year_up_to && $user_year_from != $sql_year_from && $user_year_from != $sql_year_up_to){
            return "Empty";
        }else if($user_year_from == $user_year_up_to && $user_year_from == $sql_year_from && $user_year_from == $sql_year_up_to){
            if( ($user_mounth_from == $sql_mounth_from && $user_mounth_up_to == $sql_mounth_up_to && $user_mounth_from == $user_mounth_up_to) &&
            ( ($user_day_from >= $sql_day_up_to) || ($user_day_up_to <= $sql_day_from) ) ){
                return "Empty";
            }else if(($user_mounth_from > $sql_mounth_up_to) || ($user_mounth_up_to < $sql_mounth_from )){
                return "Empty";
            }else if(($user_day_from >= $sql_day_up_to) && ($user_mounth_from == $sql_mounth_up_to)){
                return "Empty";
            }else if(($user_day_up_to <= $sql_day_from) && ($user_mounth_up_to == $sql_mounth_from)){
                return "Empty";
            }else return "Busy";
        }else if(($user_year_from > $sql_year_up_to) || ($user_year_up_to < $sql_year_from )){
            return "Empty";
        }else if(($user_mounth_from > $sql_mounth_up_to) && ($user_year_from == $sql_year_up_to)){
            return "Empty";
        }else if(($user_mounth_up_to < $sql_mounth_from) && ($user_year_up_to == $sql_year_from)){
            return "Empty";
        }else if(($user_mounth_from == $sql_mounth_up_to) && ($user_year_from == $sql_year_up_to) && ($user_day_from >= $sql_day_up_to)){
            return "Empty";
        }else if(($user_mounth_up_to == $sql_mounth_from) && ($user_year_up_to == $sql_year_from) && ($user_day_up_to <= $sql_day_from)){
            return "Empty";
        }else return "Busy";
    }
    
?>