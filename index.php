<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PM 2.5">
  <meta name="keywords" content="PM 2.5">
  <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/card.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel='stylesheet' href='https://rawcdn.githack.com/SochavaAG/example-mycode/master/_common/css/reset.css'>
  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <title>PM2.5</title>
</head>
<style>
  html {
    overflow-y: auto !important;
  }
  @media only screen and (max-width: 639px) {/*Mobile*/
  .ag-courses_box{margin-left:10px!important;}
  .font_air{
    font-size: 30px!important;
    /* text-shadow: 2px 2px 0px #D0F0C0!important; */
  }
  .pod{
    font-size: 25px!important;
    /* text-shadow: 2px 2px 0px #043927!important; */
  }
  #AQI{
    font-size: 30px!important;
    /* text-shadow: 2px 2px 0px #043927!important; */
  }
  #card_aqi{
    padding: 10px 10px!important;/* top side */
    padding-bottom:0px!important;
  }
  }
  .explain{
  text-align: center!important;
}
</style>
<body>

    <!-- NavBar   -->
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary" style="background-color: #E7F6F2 !important;">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><strong>PM2.5</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="historical.php"><i class="fa-solid fa-clock-rotate-left"></i> Historical Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-phone"></i> Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav><br><br>
  <!-- NavBar -->

  <!-- Card -->
<div class="ag-format-container" style="width: 95%;">
  <div class="ag-courses_item" style="margin-top: 45px;border-top-right-radius: 200px; /* กำหนดความโค้งด้านขวามุม */
  border-bottom-right-radius: 200px; /* กำหนดความโค้งด้านขวามุม */">
        <a href="#" class="ag-courses-item_link" id="card_aqi">
          <div class="ag-courses-item_title">
          <span class="font_air" id="font_air" style="font-size:50px;">Air Quality Index </span>  <br><br>
          <div>
            <i id="icon" class="fa-solid fa-lungs pod" style="font-size:40px;"></i> <span id="AQI" style="font-size:50px;"></span>
            &nbsp;&nbsp;<span id="explain"></span>
          </div>
          </div>
        </a>
      </div>

      <div class="ag-courses_box" style="margin-top: -50px;">
      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(1);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            PM2.5 <br><br>
            <i class="fa-solid fa-mask-face"></i> <span id="pmValue"></span> ug/m3
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(0);Chart_Temp(1);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);">
          <div class="ag-courses-item_bg"></div>

          <div class="ag-courses-item_title">
            Temperature <br><br>
            <i class="fa-solid fa-temperature-three-quarters"></i> <span id="tempValue"></span><sup>๐<sub>C</sub></sup>
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(0);Chart_Temp(0);Chart_Humid(1);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Humidity <br><br>
            <i class="fa-solid fa-droplet"></i> <span id="humidValue"></span> g/m3
            <!-- g/m<sup>3</sup> -->
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(1);Chart_Speed(0);Chart_Direction(0);">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Air Pressure <br><br>
            <i class="fa-solid fa-cloud"></i><!--<sup><i class="fa-solid fa-arrow-down"></i></sup>--> <span id="airValue"></span> hPa
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(1);Chart_Direction(0);">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Wind Speed <br><br>
            <i class="fa-solid fa-wind"></i> <span id="speedValue"></span> km/h
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a href="#myChar" class="ag-courses-item_link" onclick="Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(1);">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Wind Direction <br><br>
            <i class="fa-solid fa-compass"></i> <span id="windValue"></span> <sup>๐</sup>
          </div>
        </a>
      </div>
    </div>
</div>
    <!-- Card -->
  
    <!-- Chart -->
    <div class="chart">
    <div class="chartBox">
    <canvas id="myChart"></canvas>
    </div>
    </div>
    <script src="js/Chart.js"></script>
    <script src="js/getValues.js"></script>
    <script src="js/AQI.js"></script>
    <br>
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