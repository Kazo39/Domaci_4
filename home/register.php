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
    <h2 class="fst-italic mt-5 text-center">Registrujte se</h2>
    <div class="col-6 offset-3 mt-5">
        <form action="<?=$app_link?>/backend/auth/register.php" method="POST">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg fs-3">Prijava</p>
                    <input type="email" class="form-control" name="email" placeholder="Email">

                    <input type="password" class="form-control mt-3" name="password" placeholder="Šifra">

                    <input type="text" class="form-control mt-3" name="first_name" placeholder="Ime">

                    <input type="text" class="form-control mt-3" name="last_name" placeholder="Prezime">

                    <input type="text" class="form-control mt-3" name="passport_number" placeholder="Broj pasoša">

                    <select  class="form-control mt-3" name="country">
                        <option value="0" disabled selected>-- Odaberite državu --</option>
                        <?php
                            $sql = "SELECT id,name FROM countries ORDER BY name";
                            $res = mysqli_query($db_conn, $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "
                                        <option value=\"$row[id]\">$row[name]</option>
                                    ";
                            }
                        ?>
                    </select>

                    <button class="btn btn-primary float-end mt-3">Registracija</button>

                    <a class=" float-start mt-3" href="<?=$app_link?>/home/login.php">Prijavite se</a>
                </div>
            </div>
        </form>
    </div>
    
  </div>
</div>

  

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>

</body>