<?php


    session_start();
    include "../backend/config.php";
    include "../backend/connect.php";
    include "../backend/functions.php";
    authorize();
    isAdmin();

    

    if(isset($_GET['vehicle_id']) && isset($_GET['registry_number'])){
        $vehicle_id = $_GET['vehicle_id'];
        $registry_number = $_GET['registry_number'];
        $_SESSION['vehicle_id'] = $_GET['vehicle_id'];
        $_SESSION['registry_number'] = $_GET['registry_number'];
    }else{
        header("location:vehicles.php?msg=error...");
    }

    $sql = "SELECT v.id as vehicle_id, 
                v.registry_number, 
                v.price_per_day, 
                v_i.*, 
                v_c.id as class_id
                FROM vehicles v 
                LEFT JOIN vehicle_images v_i ON v.id = v_i.vehicle_id AND v.id = $vehicle_id
                LEFT JOIN vehicle_class v_c on v.vehicle_class_id = v_c.id
            WHERE registry_number = '$registry_number'";
    
    
    $res = mysqli_query($db_conn, $sql);
    $vehicle = [];
    while($row = mysqli_fetch_assoc($res)){   
        $vehicle[] = $row;
    };
    
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
  <link rel="stylesheet" href="./style.css"></link>
</head>
<body>
<?php include "../partials/navbar.php" ?>

    <div class="container">

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="fst-italic text-center">Izmjena detalja o vozilu</h2>
            </div>
        </div>

        <form action="./update_vehicle.php" method="POST" enctype="multipart/form-data">
            <div class="row mt-5">

                <div class="form-floating mb-3 col-4">
                    <input type="text" class="form-control" name="new_registry_number" id="new_registry_number" placeholder="Registarski broj" value="<?=$vehicle[0]['registry_number']?>">
                    <label for="new_registry_number" class="ms-2">Registarski broj</label>
                </div>

                <div class="form-floating mb-3 col-4">
                    <input type="text" class="form-control" name="new_price_per_day" id="new_price_per_day" placeholder="Cijena po danu" value="<?=$vehicle[0]['price_per_day']?>">
                    <label for="new_price_per_day" class="ms-2">Cijena po danu</label>                    
                </div>

                <div class="col-4">
                    <select name="vehicle_class" id="vehicle_class" class="form-control">
                        <option value="0" disabled>--Izaberite klasu vozila--</option>
                        <?php
                            $sql = "SELECT * FROM vehicle_class ORDER BY name";

                            $res = mysqli_query($db_conn, $sql);
                            $class_id = $vehicle[0]['class_id'];
                            
                            while($row = mysqli_fetch_assoc($res)){
                                $selected = "";
                                if($row['id'] == $class_id) $selected = "selected";
                                echo "<option $selected value = \"$row[id]\">$row[name]</option>";
                            };    
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mt-5">
                <?php
                    foreach($vehicle as $vehicleIMG){
                        if($vehicleIMG['path']) echo "<div class=\"col-3\"><a href=\"./delete_image.php?image_path=$vehicleIMG[path]\"><i class=\"fa-solid fa-trash  mb-5 ms-5 mt-5\"></i></a><img src=\"$vehicleIMG[path]\" alt=\"\" class=\"img rounded ms-4 \" ></div>";
                    }
                ?>
            </div>

            <div class="row mt-5">
                <div class="col-6 offset-3">
                    <label for="vehicle_images" class="form-control mb-3">Unesite nove fotografije</label>
                    <input type="file" name="files[]" multiple class="form-control" id="vehicle_images">
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