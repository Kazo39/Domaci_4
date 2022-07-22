<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    $active_page = '';
    if(!isset($_GET['id']) || !isset($_GET['name'])){
        header("location:./models.php?msg=error");
        exit;
    }else{
        $id = $_GET['id'];
        $name = $_GET['name'];
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rent a car | Index</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />
</head>
<body>
<?php include "../../partials/navbar.php"; ?>

<div class="container">
  <div class="row mt-5">
    <h2 class="text-center fst-italic">Izmjena modela</h2>

  <div class="row mt-4">
    <div class="col-6 offset-3">
        <form action="./save_update.php" method="POST">
            <input type="text" name="new_name" id="new_name" value="<?=$name?>" class="form-control">
            <input type="hidden" name="id" id="id" value="<?=$id?>" class="form-control">
            <button class="form-control btn btn-success  mt-3">Sačuvaj</button>
        </form>
    </div>
  </div>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>

</body>