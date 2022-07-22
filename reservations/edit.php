<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    

    if(isset($_GET['res_id']) && isset($_GET['vehicle_id']) && isset($_GET['r_number'])){

        $res_id = $_GET['res_id'];
        $vehicle_id = $_GET['vehicle_id'];
        $r_number = $_GET['r_number'];
        $_SESSION['vehicle_id'] = $_GET['vehicle_id'];
        $_SESSION['res_id'] = $_GET['res_id'];
    }else{
        header("location:../index.php?msg=error...");
    }

    $sql = "SELECT
                r.id,
                r.price,
                v_i.*,
                v.price_per_day,
                v_c.name AS class_name,
                v_m.name AS manufacturer_name,
                v_m.id AS manufacturer_id,
                v_model.name AS model_name,
                v_model.id AS model_id,
                DATE_FORMAT(r.date_from, '%Y-%m-%d') AS date_from,
                DATE_FORMAT(r.date_up_to, '%Y-%m-%d') AS date_up_to
                FROM vehicles v
                LEFT JOIN vehicle_images v_i ON v.id = v_i.vehicle_id AND v.id = $vehicle_id
                LEFT JOIN vehicle_manufacturer v_m on v.manufacturer_id = v_m.id
                LEFT JOIN vehicle_model v_model ON v.model_id = v_model.id
                LEFT JOIN vehicle_class v_c ON v.vehicle_class_id = v_c.id
                LEFT JOIN reservations r on r.id = $res_id
            WHERE registry_number = '$r_number';";

    $res = mysqli_query($db_conn, $sql);
    $reservation = [];
    while($row = mysqli_fetch_assoc($res)){
        $reservation[] = $row;
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
  <link rel="stylesheet" href="<?=$app_link?>/vehicles/style.css"></link>
</head>
<body>

    <div class="container">

        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-danger col-8 offset-2 d-none" role="alert" id="error_div"></div>
                <div class="alert alert-success col-8 offset-2 d-none" role="alert" id="success_div"></div>
                <h2 class="fst-italic text-center">Rezervacija</h2>
            </div>
        </div>



        <div class="row mt-5">
            <div class="col-6 offset-3 ">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Proizvodjac</th>
                            <th>Model</th>
                            <th>Godina proizvodnje</th>
                            <th>Klasa</th>
                            <th>Cijena po danu</th>
                            <th>Odaberite vozilo</th>
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
                                        WHERE v.id != $vehicle_id
                                    ORDER BY v_c.name";
                                    
                            $res = mysqli_query($db_conn, $sql);
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                        <td>$row[manufacturer_name]</td>
                                        <td>$row[model_name]</td>
                                        <td>$row[year_released]</td>
                                        <td>$row[class_name]</td>
                                        <td>".number_format($row['price_per_day'], 2)." €</td>
                                        <td><i class=\"fa-solid fa-circle-arrow-left\" onclick=\"getVehicleDetails($row[id])\"></i></td>   
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="row mt-5">
            <div class="col-4 ">
                <input type="date" class="form-control" name="date_from" id="date_from" value="<?=$reservation[0]['date_from']?>"> 
                <label for="date_from" class="form-control mt-3">Početni datum</label>
            </div>
            <div class="col-4 ">
                <input type="date" class="form-control" name="date_up_to" id="date_up_to" value="<?=$reservation[0]['date_up_to']?>"> 
                <label for="date_up_to" class="form-control mt-3">Krajnji datum</label>
            </div>
            <div class=" col-4">   
                <h5 class="form-control text-center pb-2">
                    <p class="ml-5" id="vehicle_price_per_day">Cijena vozila po danu: <?=number_format($reservation[0]['price_per_day'], 2)?> €</p>
                </h5>  
            </div>   
        </div>

        <div class="row mt-5" id="vehicle_images_div">
            <?php
                foreach($reservation as $vehicleIMG){
                    if($vehicleIMG['path']) echo "<div class=\"col-3\"><img src=\"$vehicleIMG[path]\" alt=\"\" class=\"img rounded ms-4 \" ></div>";
                }
            ?>
        </div>


        <div class="row mt-4">   
            <div class="col-12">
                <button class="btn btn-success float-end mb-5" id="save_button" onclick="reservationReview(<?=number_format($reservation[0]['price_per_day'], 2)?>)">Sačuvaj</button>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pregled rezervacije</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-8 offset-2">
                                <h5>Lični podaci</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 offset-2 mt-2" id="first_name">Ime: <?= $_SESSION['client']['first_name']?></div>
                            <div class="col-8 offset-2 mt-2" id="last_name">Prezime: <?= $_SESSION['client']['last_name']?></div>
                            <div class="col-8 offset-2 mt-2" id="last_name">Broj pasoša: <?= $_SESSION['client']['passport_number']?></div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-8 offset-2">
                                <h5>Podaci o vozilu</h5>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-8 offset-2 mt-2" id="manufacturer">Proizvođač: <?= $reservation[0]['manufacturer_name']?></div>
                            <div class="col-8 offset-2 mt-2" id="model">Model: <?= $reservation[0]['model_name']?></div>
                            <div class="col-8 offset-2 mt-2" id="class">Klasa: <?= $reservation[0]['class_name']?></div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-8 offset-2">
                                <h5>Podaci o rezervaciji</h5>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-8 offset-2 mt-2" id="date_from_modal"></div>
                            <div class="col-8 offset-2 mt-2" id="date_up_to_modal"></div>
                            <div class="col-8 offset-2 mt-2" id="total_price"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
                        <button type="button" id="submit_button" class="btn btn-primary" onclick="createReservation(<?=number_format($reservation[0]['price_per_day'], 2)?>)">Rezerviši</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/dc703f6088.js"></script>
<script>
    var myModalEl = document.getElementById('reservationModal');
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    var errorDiv = document.getElementById('error_div');
    var successDiv = document.getElementById('success_div');
    var v_id = <?=$_SESSION['vehicle_id']?>;

    function reservationReview(price){
        errorDiv.classList.add('d-none');       
        successDiv.classList.add('d-none');       
        const d = new Date();
        let date_from = document.getElementById('date_from').value;
        let date_up_to = document.getElementById('date_up_to').value;

        let date_from_month = (new Date(date_from)).getMonth();
        let date_up_to_month = (new Date(date_up_to)).getMonth();

        let date_from_day = (new Date(date_from)).getDate();
        let date_up_to_day = (new Date(date_up_to)).getDate();

        let date_from_year = (new Date(date_from)).getYear();
        let date_up_to_year = (new Date(date_up_to)).getYear();

        if(!date_from || !date_up_to){
            errorDiv.innerHTML = "Nisu unijeti svi podaci!";
            errorDiv.classList.remove('d-none');
            return
        }
        if( ((date_from_month == d.getMonth()) && ((date_from_day - d.getDate()) < 1) && (date_from_year == d.getYear())) || (date_from_year < d.getYear())){
            errorDiv.innerHTML = "Početak rezervacije moze bit najranije od sjutrašnjeg dana!";
            errorDiv.classList.remove('d-none');
            return
        }

        if( ((date_from_month == date_up_to_month) && (date_from_day >= date_up_to_day) && (date_from_year == date_up_to_year)) || 
            ( (date_from_month > date_up_to_month) && (date_from_year == date_up_to_year) ) || 
            (date_from_year > date_up_to_year)){
            errorDiv.innerHTML = "Početak rezervacije mora biti prije kraja rezervacije!";
            errorDiv.classList.remove('d-none');
            return
        }

        let diff_days = getDaysdiffBetweenDates(new Date(date_from),new Date(date_up_to));
        let total_price = price * diff_days;

        document.getElementById('total_price').innerHTML = `Ukupna cijena je: ${total_price} €`;
        document.getElementById('date_from_modal').innerHTML = `Početak rezervacije: ${date_from}`;
        document.getElementById('date_up_to_modal').innerHTML = `Kraj rezervacije: ${date_up_to}`;
        modal.show();
        
    }

    async function createReservation(price){
        
        let date_from = document.getElementById('date_from').value;
        let date_up_to = document.getElementById('date_up_to').value;
        let diff_days = getDaysdiffBetweenDates(new Date(date_from),new Date(date_up_to));
        let total_price = price * diff_days;
        
        let response = await 
        fetch("<?=$app_link?>/reservations/save_update.php?total_price="+total_price+"&date_from="+date_from+"&date_up_to="+date_up_to+"&v_id="+v_id+"&res_id="+<?=$_SESSION['res_id']?>);
        let responseJSON = await response.json();
        if(responseJSON.message == "Empty"){
            successDiv.innerHTML = "Rezervacija uspješno izmijenjena."
            successDiv.classList.remove('d-none');
            modal.hide();
            window.location.href = "../index.php?msg=success";
        }else if(responseJSON.message == "Error"){
            errorDiv.innerHTML = `Nije moguće izmijeniti rezervaciju, došlo je do greške.`
            errorDiv.classList.remove('d-none');
            modal.hide();
        }else{
            errorDiv.innerHTML = `Nije moguće izmijeniti rezervaciju jer u periodu koji ste odabrali ima drugih sa kojima se poklapa,
            pokušajte da izaberete neki drugi datum.`
            errorDiv.classList.remove('d-none');
            modal.hide();
        }

    }

    function getDaysdiffBetweenDates(startDate, endDate){
        var onedaySecond = 1000 * 3600 * 24;
        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
        var diffDays = Math.floor(timeDiff / onedaySecond);
        return diffDays;
    }

    

    async function getVehicleDetails(id){
        let response = await fetch("<?=$app_link?>/vehicles/get_vehicle_details.php?vehicle_id="+id);
        let responseJSON = await response.json();
        imgHTML = "";
        responseJSON.forEach((vehicleImg) => {
            imgHTML += `<div class=\"col-3\"><img src="${vehicleImg.path}" alt=\"\" class=\"img rounded ms-4 \" ></div>`;
        })
        v_id = responseJSON[0].id;
        document.getElementById('vehicle_images_div').innerHTML = imgHTML;
        document.getElementById('manufacturer').innerHTML = `Proizvođač: ${responseJSON[0].manufacturer_name}`;
        document.getElementById('model').innerHTML = `Model: ${responseJSON[0].model_name}`;
        document.getElementById('class').innerHTML = `Klasa: ${responseJSON[0].class_name}`;
        document.getElementById('vehicle_price_per_day').innerHTML = `Cijena vozila po danu: ${responseJSON[0].price_per_day}`;
        document.getElementById('save_button').setAttribute("onclick", `reservationReview(${responseJSON[0].price_per_day})`)
        document.getElementById('submit_button').setAttribute("onclick", `createReservation(${responseJSON[0].price_per_day})`)
    }
</script>
</body>