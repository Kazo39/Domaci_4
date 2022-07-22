<?php

    session_start();  
    include "./backend/config.php";
    include "./backend/connect.php";
    include "./backend/functions.php";
    authorize();
    $active_page = 'index';
    $client_id = $_SESSION['client']['id'];
    
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
<?php include "partials/navbar.php"; ?>

<div class="container">
  <div class="row mt-5">
    <div class="alert alert-danger col-8 offset-2 d-none" role="alert" id="alertDiv">
      Rezervacija nije otkazana, došlo je do greške.
    </div>
    <h2 class="text-center fst-italic">Sve rezervacije</h2>

    <div class="col-12 <?php if($_SESSION['client']['is_admin'] == 1) echo "d-none" ?>">
      <a href="<?=$app_link?>/reservations/create_new_reservation.php" class="btn btn-primary float-end">Napravi novu rezervaciju</a>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-8 offset-2">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Proizvodjac vozila</th>
            <th>Marka vozila </th>
            <th>Ime klijenta</th>
            <th>Prezime klijenta</th>
            <th>Pocetak rezervacije</th>
            <th>Kraj rezervacije</th>
            <th>Ukupna Cijena</th>
            <?php
              if($_SESSION['client']['is_admin'] == 0){
                echo "
                  <th>Otkazi rezervaciju</th>
                  <th>Izmijeni rezervaciju</th>
                ";
              }
            ?>
          </tr>
        </thead>
        <tbody>
        <?php
          $and_query = "";
          if($_SESSION['client']['is_admin'] == 0) $and_query = " AND c.id = $client_id";
          $sql = "SELECT
                    r.price,
                    r.id, 
                    model.name AS model, 
                    manufacturer.name AS manufacturer, 
                    c.first_name, 
                    c.last_name,
                    r.is_active,
                    v.registry_number,
                    v.id as vehicle_id,
                    DATE_FORMAT(date_from, '%d.%m.%Y') as formatted_date_of,
                    DATE_FORMAT(date_up_to, '%d.%m.%Y') as formatted_date_up_to
                    FROM reservations r
                    JOIN vehicles v ON r.vehicle_id = v.id
                    JOIN clients c ON r.client_id = c.id
                    JOIN vehicle_model model on v.model_id = model.id
                    JOIN vehicle_manufacturer manufacturer ON v.manufacturer_id = manufacturer.id 
                    WHERE r.is_active = true
                  $and_query";

          $res = mysqli_query($db_conn, $sql);

          while($row = mysqli_fetch_assoc($res)){

            echo "
                    <tr>
                      <td>$row[manufacturer]</td>
                      <td>$row[model]</td>
                      <td>$row[first_name]</td>
                      <td>$row[last_name]</td>
                      <td>$row[formatted_date_of]</td>
                      <td>$row[formatted_date_up_to]</td>
                      <td>".number_format($row['price'], 2)."€</td>
                  ";
                  if($and_query != ""){
                    echo "
                      <td><a onclick=\"getReservationId($row[id])\"><i class=\"fa-solid fa-trash\"></i></a></td>
                      <td>
                        <a href=\"$app_link/reservations/edit.php?res_id=$row[id]&vehicle_id=$row[vehicle_id]&r_number=$row[registry_number]\">
                          <i class=\"fa-solid fa-pencil\"></i>
                        </a>
                      </td>
                      </tr>
                    ";
                  }
          };
    
        ?>
        </tbody>
      </table>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Otkazivanje rezervacije</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Da li stvarno želite da otkažete rezervaciju?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne</button>
          <button type="button" class="btn btn-primary" onclick="cancelReservation()" >Da</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
  let res_id = null;
  var myModalEl = document.getElementById('cancelReservationModal');
  var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

  function getReservationId(reservation_id){
    res_id=reservation_id;
    modal.show();
  }

  async function cancelReservation(){
    let response = await fetch("<?=$app_link?>/reservations/cancel_reservation.php?reservation_id="+res_id);
    let responseJSON = await response.json();
    
    if(responseJSON.status == 'fail'){
      document.getElementById('alertDiv').classList.remove('d-none');
    }else{
    modal.hide();
    window.location.reload(true);
    }

  }
  
</script>
</body>