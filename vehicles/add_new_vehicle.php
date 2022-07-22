<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
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
<?php include "../partials/navbar.php" ?>

<div class="container">
    <form action="save.php" method="POST" enctype="multipart/form-data">
        <div class="row mt-5">

            <div class="row">
                <div class="col-12">
                    <h2 class="fst-italic text-center">Dodavanja novog vozila</h2>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-6">
                    <select name="vehicle_manufacturer" id="vehicle_manufacturer" class="form-control" onchange="choosingManufacturer()">
                        <option value="0" selected disabled>-- Izaberite vec postojećeg ili dodajte novog -- </option>
                        <option value="new_vehicle_manufacturer">Novi proizvođač</option>
                        <option value="existing_manufacturer">Postojeći proizvođač</option>
                    </select>
                </div>

                <div class="col-6" id="manufacturer"></div>
            </div>

            <div class="row mt-5 " id="vehicleModelDiv">

                <div class="col-6 offset-3 d-none" id="vehicleModelInput">
                    <input type="text" placeholder="Unesite model vozila" class="form-control" id="new_vehicle_model" name="new_vehicle_model">
                </div>

                <div class="col-6 d-none" id="vehicleModelSelect">
                    <select name="vehicle_model" id="vehicle_model" class="form-control" onchange="choosingModel()">
                        <option value="0" selected disabled>-- Izaberite vec postojeći ili dodajte novi -- </option>
                        <option value="new_vehicle_model">Novi model</option>
                        <option value="existing_model">Postojeći model</option>
                    </select>
                </div>

                <div class="col-6 d-none" id="vehicleModelsListDiv" name="vehicleModelsListDiv"></div>

            </div>

            <div class="row mt-5">
                <div class="col-6">
                    <select name="vehicle_class" id="vehicle_class" class="form-control">
                        <option value="0" selected disabled>-- Izaberite klasu vozila -- </option>
                        <?php
                            $sql = "SELECT * FROM vehicle_class ORDER BY name";
                            $res = mysqli_query($db_conn, $sql);

                            while($row = mysqli_fetch_assoc($res)){
                                echo "<option value=\"$row[id]\">$row[name]</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="col-6">
                    <input type="text" placeholder="Unesite registarski broj vozila" class="form-control" name="registry_number">
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-6">
                    <input type="number" placeholder="Unesite cijenu po danu" class="form-control" name="price_per_day">
                </div>

                <div class="col-6">
                    <input type="text" placeholder="Unesite godinu proizvodnje" class="form-control" name="year_realesed">  
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-6 offset-3">
                    <label for="vehicle_photos" class="text-center form-control mb-3">Unesite fotografije vozila</label>
                    <input type="file" name="files[]" multiple class="form-control" id="vehicle_photos">         
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <button class="btn btn-success float-end ">Sačuvaj</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
    async function choosingManufacturer(){
        let decision = document.getElementById('vehicle_manufacturer').value;

        var manufacturerHTML = "";
        var modelHTML = "";
        document.getElementById('vehicleModelSelect').classList.add('d-none');
        document.getElementById('vehicleModelInput').classList.add('d-none');
        document.getElementById('vehicleModelsListDiv').classList.add('d-none');
        

        if(decision == "new_vehicle_manufacturer"){
            manufacturerHTML += `<input class="form-control" name="new_manufacturer" id="new_manufacturer" placeholder="Naziv novog proizvođača">`;
            document.getElementById('vehicleModelInput').classList.remove('d-none');
        }else if(decision == "existing_manufacturer"){
            let HTML = await getAllManufacturers();
            manufacturerHTML += HTML;
            document.getElementById('vehicleModelSelect').classList.remove('d-none');
        }
        document.getElementById('manufacturer').innerHTML = manufacturerHTML;

    }

    async function getAllManufacturers(){
        response = await fetch("<?=$app_link?>/vehicles/get_manufacturers.php");
        responseJSON = await response.json();
        
        let HTML = `<select name="all_manufacturers" id="all_manufacturers" class="form-control" onchange="choosingModel()">`;

        responseJSON.forEach((manufacturer) => {
            HTML += `<option value="${manufacturer.id}">${manufacturer.name}</option>`;
        });
        HTML += "</select>";
        
        return HTML;
    }

    async function choosingModel(){
        let decision = document.getElementById('vehicle_model').value;
        let divModelHTML = "";
        if(decision == "new_vehicle_model"){
            divModelHTML += `<input class="form-control" id="new_model" placeholder="Naziv novog modela" name="new_model">`;
        }else if(decision == "existing_model"){
            let HTML = await getAllModels();
            divModelHTML += HTML;
        }
        document.getElementById('vehicleModelsListDiv').innerHTML = divModelHTML;
        document.getElementById('vehicleModelsListDiv').classList.remove('d-none');
    }

    async function getAllModels(){
        let manufacturer_id = document.getElementById('all_manufacturers').value;
        response = await fetch("<?=$app_link?>/vehicles/get_models.php?manufacturer_id="+manufacturer_id);
        responseJSON = await response.json();
        
        let HTML = `<select name="all_models" id="all_models" class="form-control">`;

        responseJSON.forEach((model) => {
            HTML += `<option value="${model.id}">${model.name}</option>`;
        });
        HTML += "</select>";
        
        return HTML;
    }

</script>
</body>