<?php
    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    $active_page = 'clients';
    
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
        <h2 class="text-center fst-italic">Podaci o nalogu</h2>
    </div>
    <form action="./save_update.php" method="POST">
        <div class="row mt-4">
            <div class="col-4 offset-1">
            <input type="text" name="first_name" value="<?=$_SESSION['client']['first_name']?>" class="form-control" placeholder="Ime">
            </div>

            <div class="col-4 offset-1">
            <input type="text" name="last_name" value="<?=$_SESSION['client']['last_name']?>" class="form-control" placeholder="Prezime">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-4 offset-1">
            <input type="email" name="email" value="<?=$_SESSION['client']['email']?>" class="form-control" placeholder="Email">
            </div>

            <div class="col-4 offset-1">
            <input type="text" name="passport_number" value="<?=$_SESSION['client']['passport_number']?>" class="form-control" placeholder="Broj pasoša">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-4 offset-1">
            <input type="password" name="old_password" placeholder="Unesite vašu staru lozinku" class="form-control" > 
            </div>

            <div class="col-4 offset-1">
                <input type="password" name="new_password" placeholder="Unesite vašu novu lozinku ako želite" class="form-control">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6 offset-3">
                <select name="country" id="country" class="form-control">
                    <option value="0" disabled>--Izaberite državu</option>
                    <?php
                    
                        $country_id = $_SESSION['client']['country_id'];
                        $sql = "SELECT * FROM countries ORDER BY name";
                        $res = mysqli_query($db_conn, $sql);

                        while($row = mysqli_fetch_assoc($res)){
                            $selected = "";
                            if($row['id'] == $country_id) $selected = "selected";
                            echo "<option $selected value=\"$row[id]\">$row[name]</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <button class="btn btn-success float-end mb-4">Sačuvaj</button>
            </div>
        </div>
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
</body>