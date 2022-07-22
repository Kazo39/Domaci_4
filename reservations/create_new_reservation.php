<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
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
<?php include "../partials/navbar.php"; ?>

<div class="container">
    <div class="row mt-5">
        <div class="row">
            <h2 class="text-center fst-italic">Odaberite vozilo</h2>
        </div>

        
        <div class="row">
            <div class="col-10 offset-1 mt-5 ">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Proizvodjac</th>
                            <th>Model</th>
                            <th>Godina proizvodnje</th>
                            <th>Klasa</th>
                            <th>Registarski broj</th>
                            <th>Cijena po danu</th>
                            <th>Odaberi vozilo</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $sql = "SELECT
                                        v.id,
                                        v.registry_number,
                                        v.year_released,
                                        v_c.name as class_name,
                                        v_m.name as manufacturer_name,
                                        v_model.name as model_name,
                                        v.price_per_day
                                        FROM `vehicles` v
                                        LEFT JOIN vehicle_class v_c ON v.vehicle_class_id = v_c.id
                                        LEFT JOIN vehicle_manufacturer v_m ON v_m.id = v.manufacturer_id 
                                        LEFT JOIN vehicle_model v_model ON v_model.manufacturer_id = v_m.id AND v_model.id = v.model_id
                                    ORDER BY v_c.name";
                                    
                            $res = mysqli_query($db_conn, $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                        <td>$row[manufacturer_name]</td>
                                        <td>$row[model_name]</td>
                                        <td>$row[year_released]</td>
                                        <td>$row[class_name]</td>
                                        <td>$row[registry_number]</td>
                                        <td>".number_format($row['price_per_day'], 2)." €</td>   
                                        <td><a href=\"./new_reservation_details.php?vehicle_id=$row[id]&r_number=$row[registry_number]\"><i class=\"fa-solid fa-plus\"></i></a></td>   
                                        </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
     
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
</script>
</body>