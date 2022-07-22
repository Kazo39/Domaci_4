<?php

    session_start();  
    include "../../backend/config.php";
    include "../../backend/connect.php";
    include "../../backend/functions.php";
    authorize();
    isAdmin();
    $active_page = 'classes';
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
    <div class="alert alert-danger d-none" role="alert" id="error_div"></div>
    <h2 class="text-center fst-italic">Sve klase vozila</h2>

    <div class="col-12">
      <a href="<?=$app_link?>/tables_CRUD/classes/create_new_class.php" class="btn btn-primary float-end">Dodaj novu klasu</a>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-8 offset-2">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Naziv klase</th>
            <th>Izmijeni</th>
            <th>Obriši</th>
            
          </tr>
        </thead>
        <tbody>
        <?php
          $sql = "SELECT * FROM vehicle_class ORDER BY name";

          $res = mysqli_query($db_conn, $sql);

          while($row = mysqli_fetch_assoc($res)){
            echo "
                    <tr>
                      <td>$row[name]</td>
                      <td><a href=\"./edit.php?id=$row[id]&name=$row[name]\"><i class=\"fa-solid fa-pencil\"></i></a></td>
                      <td><i class=\"fa-solid fa-trash\" onclick=\"getId($row[id])\"></i></td>
                  ";
          };    
        ?>
        </tbody>
      </table>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade" id="deleteVehicleClassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Brisanje klase</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Da li stvarno želite da obrišete ovu klasu?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne</button>
          <button type="button" class="btn btn-primary" onclick="deleteVehicleClass()" >Da</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
  var m_id = null;
  var myModalEl = document.getElementById('deleteVehicleClassModal');
  var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
  var alertDiv = document.getElementById('error_div');
  alertDiv.classList.add('d-none');

  function getId(id){
    c_id = id;
    modal.show();
  }

  async function deleteVehicleClass(){
    let response = await fetch("<?=$app_link?>/tables_CRUD/classes/delete.php?id="+c_id);
    let responseJSON = await response.json();
    
    if(responseJSON.message == 'error'){
      modal.hide();
      alertDiv.innerHTML = "Došlo je do greške.";
      alertDiv.classList.remove('d-none');
    }else if(responseJSON.message == 'fail'){
      modal.hide();
      alertDiv.innerHTML = "Nije moguće obrisati klasu jer postoje povezani podaci.";
      alertDiv.classList.remove('d-none');
    }else{
      modal.hide();
      window.location.reload(true);
    }

  }
  
</script>
</body>