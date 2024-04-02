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
  <script type="application/javascript" src="/assets/packages/flutter_inappwebview_web/assets/web/web_support.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <title>PMStation</title>
</head>
<style>
  html {
    overflow-y: auto !important;
  }
  .form-check-input:checked {
    background-color: #C0D6E8!important; /* เปลี่ยนสีเป็นสีฟ้าเมื่อ checkbox ถูกเลือก */
    box-shadow: 0 0 5px #C0D6E8!important; /* เปลี่ยนสีเงาเป็นสีเดียวกับสีของ checkbox เมื่อ checkbox ถูกเลือก */
    border: none!important; 
  }

  @media only screen and (max-width: 639px) {

    /*Mobile*/
    .ag-courses_box {
      margin-left: 10px !important;
    }

    #Compare {
      padding-bottom: 40px;
    }

    #myChart {
      height: 600px;
    }

    .font_air {
      font-size: 30px !important;
      /* text-shadow: 2px 2px 0px #D0F0C0!important; */
    }

    .pod {
      font-size: 25px !important;
      /* text-shadow: 2px 2px 0px #043927!important; */
    }

    #AQI {
      font-size: 30px !important;
      /* text-shadow: 2px 2px 0px #043927!important; */
    }

    #card_aqi {
      padding: 10px 10px !important;
      /* top side */
      padding-bottom: 0px !important;
    }
  }

  .explain {
    text-align: center !important;
  }

  .disabled {
    pointer-events: none;
    cursor: default;
  }

  select option:checked {
    background-color: #999999;
    color: white;
  }

  select option {
    background-color: #454545;
    color: white;
  }

  select option:hover {
    background-color: #999999;
    color: white;
  }

  .form-select option {
    text-align: center;
  }

  .form-select {
    font-size: large;
  }
</style>

<body>

  <!-- NavBar   -->
  <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary" style="background-color: #E7F6F2 !important;">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><strong>PMStation</strong></a>
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
            <a class="nav-link" href="predict.php"><i class="fa-solid fa-forward-fast"></i> Predict PM2.5</a>
          </li>
        </ul>
      </div>
    </div>
  </nav><br><br>
  <!-- NavBar -->

  <!-- Card -->
  <div class="ag-format-container" style="width: 95%;">
    <div class="ag-courses_item" id="AQI_Card">
      <a class="ag-courses-item_link" id="card_aqi" onclick="">
        <div class="ag-courses-item_title">
          <span class="font_air" id="font_air" style="font-size:50px;">Air Quality Index </span> <br><br>
          <div>
            <i id="icon" class="fa-solid fa-lungs pod" style="font-size:40px;"></i> <span id="AQI" style="font-size:50px;"></span>
            &nbsp;&nbsp;<span id="explain"></span>
          </div>
        </div>
      </a>
    </div>

    <div class="ag-courses_box" style="margin-top: -50px;">
      <div class="ag-courses_item">
        <a id="Close_PM" class="ag-courses-item_link" onclick="">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            PM2.5 <br><br>
            <i class="fa-solid fa-mask-face"></i> <span id="pmValue"></span> ug/m <sup>3</sup>
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a id="Close_Temp" class="ag-courses-item_link" onclick="">
          <div class="ag-courses-item_bg"></div>

          <div class="ag-courses-item_title">
            Temperature <br><br>
            <i class="fa-solid fa-temperature-three-quarters"></i> <span id="tempValue"></span><sup>๐<sub>C</sub></sup>
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a id="Close_Humid" class="ag-courses-item_link" onclick="">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Humidity <br><br>
            <i class="fa-solid fa-droplet"></i> <span id="humidValue"></span> g/m <sup>3</sup>
            <!-- g/m<sup>3</sup> -->
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a id="Close_Pressure" class="ag-courses-item_link" onclick="">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Air Pressure <br><br>
            <i class="fa-solid fa-cloud"></i><!--<sup><i class="fa-solid fa-arrow-down"></i></sup>--> <span id="airValue"></span> hPa
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a id="Close_Speed" class="ag-courses-item_link" onclick="">
          <div class="ag-courses-item_bg"></div>
          <div class="ag-courses-item_title">
            Wind Speed <br><br>
            <i class="fa-solid fa-wind"></i> <span id="speedValue"></span> m/s
          </div>
        </a>
      </div>

      <div class="ag-courses_item">
        <a id="Close_Direction" class="ag-courses-item_link" onclick="">
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
  <div id="Compare" class="container d-flex justify-content-center">
    <div class="row">
      <div class="col d-flex justify-content-center align-items-center flex-column">
        <select id="ddlChart" class="form-select form-select-sm" aria-label="Default select example" style="width:auto;font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#f9b234" onchange="ddlChange();">
          <option style="border-radius:20px;" selected value="0">Chart PM2.5 Value</option>
          <option value="1">Chart AQI Value</option>
          <option value="2">Chart Temperature Value</option>
          <option value="3">Chart Humidity Value</option>
          <option value="4">Chart Air Pressure Value</option>
          <option value="5">Chart Wind Speed Value</option>
          <option value="6">Chart Wind Direction Value</option>
        </select>
        <div class="form-check form-switch mt-2" style="display: flex; align-items: center;">
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onchange="Chked();" style="padding: 10px; width:50px; margin-right:10px;">
          <label class="form-check-label" for="flexSwitchCheckDefault" style="font-size: 16px; margin-bottom: 0;">เปรียบเทียบข้อมูลย้อนหลัง 1 สัปดาห์</label>
        </div>
      </div>
    </div>
  </div>


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
        <i class="fa-solid fa-fax"></i> 02-8074528 - 30
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