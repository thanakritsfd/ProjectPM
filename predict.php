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
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <title>PM2.5</title>
  <style>
    .dot3 {
  top: 10%;
  height: 20px;
  width: 20px;
  margin: 5px;
  background-color:#BFBDC1;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.dot {
  top: 10%;
  height: 250px;
  width: 250px;
  margin: 40px;
  background-color: #37323E;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white; /* สีข้อความ */
  font-size: 20px; /* ขนาดข้อความ */
  border: 2px solid white; /* เพิ่ม border สีขาวขนาด 2px */
  box-sizing: border-box; /* ควบคุมการหารายได้และเส้นขอบ */
  padding: 10px; /* เพิ่มระยะห่างด้านในขอบขอบ */
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 1); /* เพิ่มกรอบ shadow */
  text-align: center;
}
  .dot-container {
    display: flex;
  justify-content: center;
  align-items: center;
  min-height: 60vh;
}
@media (max-width: 768px) {
  .dot-container {
    flex-direction: column; /* เปลี่ยนเป็นการแสดงเป็นคอลัมน์เมื่อหน้าจอเล็กขึ้น */
    text-align: center; /* จัดให้ dot อยู่กึ่งกลางแนวนอน */
  }
}
  </style>
</head>
<body class="d-flex flex-column justify-content-between">

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
            <a class="nav-link" href="predict.php"><i class="fa-solid fa-forward-fast"></i> Predict PM2.5</a>
          </li>
        </ul>
      </div>
    </div>
  </nav><br><br>
  <!-- NavBar -->

  <div class="dot-container">
  <span class="dot" id="today" style="font-size: 60px;"></span>
  <span class="dot3"></span>
  <span class="dot3"></span>
  <span class="dot" id="twelve" style="font-size: 60px;"></span>
  <span class="dot3"></span>
  <span class="dot3"></span>
  <span class="dot" id="six" style="font-size: 60px;"></span>
  <span class="dot3"></span>
  <span class="dot3"></span>
  <span class="dot" id="day" style="font-size: 60px;"></span>
</div>

<!-- footer -->
<div class="container foot">
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
<script>
var today = document.getElementById('today');
var twelve = document.getElementById('twelve');
var six = document.getElementById('six');
var day = document.getElementById('day');

today.innerHTML = "Now<br>25";
twelve.innerHTML = "6 hr.<br>27<br>";
six.innerHTML = "12 hr.<br>29";
day.innerHTML = "24 hr.<br>30";

</script>