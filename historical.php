<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PM 2.5">
  <meta name="keywords" content="PM 2.5">
  <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="./css/datePicker.css">
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/table2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
  <script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
  <script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>
  <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/Historical.js"></script>
    <title>Historical Data</title>
</head>
<body>
    <!-- NavBar   -->
  <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary" style="background-color: #E7F6F2 !important;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><strong>PM2.5</strong></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-phone"></i> Contact Us</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Menu
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="historical.php">Historical Data</a></li>
              <li><a class="dropdown-item" href="#">menu 2</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">menu 3</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav><br><br>
  <!-- NavBar -->

      <main class="cd__main" style="margin-top: 4%;">

<!-- form -->
<form id="myForm" class="rows gy-2 gx-3 align-items-center">
<div class="row">
  <div class="col">
  <label class="form-label" for="date2">Start Date</label>
    <div class="form-outline">
    <input type="date" id="startDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY"><!-- DatePicker -->
    </div>
  </div>
  <div class="col">
  <label class="form-label" for="date2">End Date</label>
    <div class="form-outline">
      <input type="date" id="endDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY"><!-- DatePicker -->
    </div>
  </div>
  <div class="col">
  <label class="form-label" for="date2">&nbsp;</label>
    <div class="form-outline">
      <button type="button" class="btn btn-primary btn-block mb-4"><b>Confirm</b></button>
    </div>
  </div>
</div>
</form>
<!-- form -->

         <table id="example" class="table table-striped" style="width:100%!important">
        <thead>
            <tr>
                <th>No.</th>
                <th>PM2.5</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Air Pressure</th>
                <th>Wind Speed</th>
                <th>Wind Direction</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody><?php include_once "./api/value_Sensor/api_getValueTable.php"; ?>
        </tbody>
    </table>
         <!-- END EDMO HTML (Happy Coding!)-->
      </main>
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
<script type="text/javascript">
    //date-picker
    document.getElementById('startDate').value = formatDate();
    document.getElementById('endDate').value = formatDate();

    $("#startDate").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format( this.getAttribute("data-date-format") )
        )
    }).trigger("change")

    $("#endDate").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format( this.getAttribute("data-date-format") )
        )
    }).trigger("change")

function padTo2Digits(num) {
  return num.toString().padStart(2, '0');//padStart(มี 2 ตำแหน่ง, เริ่มด้วย '0') Ex. '02'
}
function formatDate(date = new Date()) {
  return [
    date.getFullYear(),
    padTo2Digits(date.getMonth() + 1),
    padTo2Digits(date.getDate()),
  ].join('-');
}
</script>