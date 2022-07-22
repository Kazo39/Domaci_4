<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    isAdmin();
    $active_page = 'vehicles';
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
            <div class="alert alert-danger col-8 offset-2 d-none" role="alert" id="alertDiv">
                Nije moguce obrisati ovo vozilo jer postoji rezervacija za njega.
            </div>
            <h2 class="text-center fst-italic">Sva vozila</h2>
        </div>

        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary float-end" href="add_new_vehicle.php">Dodaj novo vozilo</a>
            </div>
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
                            <th>Izmijeni vozilo</th>
                            <th>Obriši vozilo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $sql = "SELECT
                                        v.id,
                                        v.registry_number,
                                        v.year_released,
                                        v_c.name AS class_name,
                                        v_m.name AS manufacturer_name,
                                        v_model.name AS model_name,
                                        v_model.id AS model_id,
                                        v.price_per_day
                                        FROM `vehicles` v
                                        LEFT JOIN vehicle_class v_c ON v.vehicle_class_id = v_c.id
                                        LEFT JOIN vehicle_manufacturer v_m ON v_m.id = v.manufacturer_id 
                                        LEFT JOIN vehicle_model v_model ON v_model.manufacturer_id = v_m.id AND v_model.id = v.model_id
                                    ORDER BY v_m.name";
                                    
                            $res = mysqli_query($db_conn, $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                        <td>$row[manufacturer_name]</td>
                                        <td>$row[model_name]</td>
                                        <td>$row[year_released]</td>
                                        <td>$row[class_name]</td>
                                        <td>$row[registry_number]</td>
                                        <td>".number_format($row['price_per_day'], 2)." €</td>
                                        <td><a href=\"./edit.php?vehicle_id=$row[id]&registry_number=$row[registry_number]\"><i class=\"fa-solid fa-pencil\"></i></a></td>
                                        <td><i class=\"fa-solid fa-trash hover-overlay\" onclick=getVehicleId($row[id],$row[model_id])></i></td>
                                        
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      <!-- Modal -->
  <div class="modal fade" id="deleteVehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Brisanje vozila</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Da li stvarno želite da obrišete ovo vozilo?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne</button>
          <button type="button" class="btn btn-primary" onclick="deleteVehicle()" >Da</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
  let vehicle_id = null;
  var myModalEl = document.getElementById('deleteVehicleModal');
  var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

  function getVehicleId(v_id, m_id){
    vehicle_id = v_id;
    model_id = m_id;
    modal.show();
  }

  async function deleteVehicle(){
    let response = await fetch("<?=$app_link?>/vehicles/delete_vehicle.php?vehicle_id="+vehicle_id+"&model_id="+model_id);
    let responseJSON = await response.json();
    
    if(responseJSON.message == 'error'){
    modal.hide();
    document.getElementById('alertDiv').classList.remove('d-none');
    }else{
    modal.hide();
    window.location.reload(true);
    }

  }
  
</script>
</body>