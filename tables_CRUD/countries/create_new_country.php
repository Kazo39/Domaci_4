<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    $active_page = '';  
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
    <h2 class="text-center fst-italic">Dodavanje nove države</h2>

  <div class="row mt-5">
    <div class="col-6 offset-3">
        <form action="./save.php" method="POST">
            <input type="text" name="name" id="name" placeholder="Unesite naziv" class="form-control">
            <button class="form-control btn btn-success  mt-3">Sačuvaj</button>
        </form>
    </div>
  </div>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>

</body>