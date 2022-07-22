<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />
</head>
<body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link  fs-5 <?php if($active_page == 'index') echo "active"?>" aria-current="page" href="<?=$app_link?>/index.php">Rezervacije</a>
              </li>
              <li class="nav-item">
              <?php
                $active = "";
                if($active_page == 'vehicles') $active = 'active';
                if($_SESSION['client']['is_admin'] == 1){
                  echo "<a class=\"nav-link fs-5 $active \" href=\"$app_link/vehicles/vehicles.php\">Vozila</a>";
                } 
              ?>
              </li>
              <li class="nav-item">
              <?php
                $active = "";
                if($active_page == 'manufacturers') $active = 'active';
                if($_SESSION['client']['is_admin'] == 1){
                  echo "<a class=\"nav-link fs-5 $active \" href=\"$app_link/tables_CRUD/manufacturers/manufacturers.php\">Proizvođači</a>";
                } 
              ?>
              </li>
              <li class="nav-item">
              <?php
                $active = "";
                if($active_page == 'models') $active = 'active';
                if($_SESSION['client']['is_admin'] == 1){
                  echo "<a class=\"nav-link fs-5 $active \" href=\"$app_link/tables_CRUD/models/models.php\">Modeli</a>";
                } 
              ?>
              </li>
              <li class="nav-item">
              <?php
                $active = "";
                if($active_page == 'classes') $active = 'active';
                if($_SESSION['client']['is_admin'] == 1){
                  echo "<a class=\"nav-link fs-5 $active \" href=\"$app_link/tables_CRUD/classes/classes.php\">Klase(vozila)</a>";
                } 
              ?>
              </li>
              <li class="nav-item">
              <?php
                $active = "";
                if($active_page == 'countries') $active = 'active';
                if($_SESSION['client']['is_admin'] == 1){
                  echo "<a class=\"nav-link fs-5 $active \" href=\"$app_link/tables_CRUD/countries/countries.php\">Države</a>";
                } 
              ?>
              </li>
              <li class="nav-item">
                <a class="nav-link  fs-5 <?php if($active_page == 'clients') echo "active"?>" aria-current="page" href="<?=$app_link?>/tables_CRUD/clients/client.php">Profil</a>
              </li>
            </ul>
            <span class="navbar-text me-3">
              <a href="<?=$app_link?>/home/logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i></a>
            </span>
          </div>
        </div>
      </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://use.fontawesome.com/dc703f6088.js"></script>
</body>