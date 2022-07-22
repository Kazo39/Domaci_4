<?php
    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    
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

<div class="container">
  <div class="row mt-5">
    <h2 class="fst-italic mt-5 text-center">Ulogujte se</h2>
    <div class="col-6 offset-3 mt-5">
        <form action="<?=$app_link?>/backend/auth/login.php" method="POST">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg fs-3">Prijava</p>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <input type="password" class="form-control mt-3" name="password" placeholder="Šifra">

                    <button class="btn btn-primary float-end mt-3">Prijava</button>

                    <a class=" float-start mt-3" href="<?=$app_link?>/home/register.php">Registracija novog korisnika</a>
                </div>
            </div>
        </form>
    </div>
    
  </div>
</div>

  

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>

</body>