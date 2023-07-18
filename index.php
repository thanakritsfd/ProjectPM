<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PM 2.5">   
    <meta name="keywords" content="PM 2.5">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> 
    <link rel='stylesheet' href='https://rawcdn.githack.com/SochavaAG/example-mycode/master/_common/css/reset.css'>
    <link rel="stylesheet" href="css/card.css">  
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <title>AQI</title>
</head>
<style>
  html{
    overflow-y: auto !important;
  }
</style>
<body>
<!-- NavBar   -->
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #E7F6F2 !important;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><strong>AQI</strong></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa-solid fa-phone"></i> Contact Us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Menu
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">menu 1</a></li>
            <li><a class="dropdown-item" href="#">menu 2</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">menu 3</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- NavBar    -->   

<!-- Card -->
<div class="ag-format-container" style="width:90%">
  <div class="ag-courses_box">
    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
            Temperature <br><br>
            <i class="fa-solid fa-temperature-three-quarters"></i> 32.20<sup>๐<sub>C</sub></sup>
        </div>
      </a>
    </div>

    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
        Humidity <br><br>
        <i class="fa-solid fa-droplet"></i> 24.04 g/m<sup>3</sup>
        </div>

      </a>
    </div>

    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
        Air Pressure <br><br>
        <i class="fa-solid fa-cloud"></i><sup><i class="fa-solid fa-arrow-down"></i></sup> 1,013.24 hPa
        </div>
      </a>
    </div>

    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
        Wind Speed <br><br>
        <i class="fa-solid fa-wind"></i> 1,013.24 km/h
        </div>

      </a>
    </div>

    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
          Wind Direction <br><br>
          <i class="fa-solid fa-compass"></i> North
        </div>

      </a>
    </div>

    <div class="ag-courses_item">
      <a href="#" class="ag-courses-item_link">
        <div class="ag-courses-item_bg"></div>

        <div class="ag-courses-item_title">
          Traffic <br><br>
          <i class="fa-solid fa-traffic-light"></i> Good
        </div>
      </a>
    </div>
</div>
<!-- Card -->

<!-- Chart -->
<div>
  <canvas id="myChart"></canvas>
</div>
<script src="js/Chart.js"></script>
<br><br><br>
<!-- Chart -->

<!-- footer -->
<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <span class="mb-3 mb-md-0 text-body-secondary"><strong>Contact Us</strong>
      <br><br><i class="fa-solid fa-location-dot"></i> 19/1 ถนนเพชรเกษม เขตหนองแขม <br> &nbsp;&nbsp; กรุงเทพ 10160
      <br><br><i class="fa-solid fa-phone"></i> 02-8074500 ต่อ 190, 192
      </span> 
    </div>
    <span>
      <i class="fa-solid fa-fax"></i> 02-8074528 – 30
      <br><br><i class="fa-solid fa-envelope"></i> info@sau.ac.th
    </span>
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <img src="images/sau.png" width="40%" alt="SAU">
    </ul>
  </footer>
</div>
<!-- footer -->

</body>
</html>