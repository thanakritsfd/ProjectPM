<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PM 2.5">
  <meta name="keywords" content="PM 2.5">
  <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/datePicker.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel='stylesheet' href='https://rawcdn.githack.com/SochavaAG/example-mycode/master/_common/css/reset.css'>
  <link rel="stylesheet" href="./css/table.css">
  <link rel="stylesheet" href="./css/table2.css">
  <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
  <script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
  <script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
  <script src="js/Historical.js"></script>  
    <title>Historical Data</title>
</head>
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

      <main class="cd__main" style="margin-top: 2%;">

<!-- form -->
<form id="myForm" class="rows gy-2 gx-3 align-items-center">
  <div class="row">
    <div class="col">
      <label class="form-label" for="date2">Start Date</label>
      <div class="form-outline">
        <input type="date" id="startDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY">
      </div>
    </div>
    <div class="col">
      <label class="form-label" for="date2">End Date</label>
      <div class="form-outline">
        <input type="date" id="endDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY">
      </div>
    </div>
    <div class="col">
      <label class="form-label" for="date2">&nbsp;</label>
      <div class="form-outline d-flex justify-content-start align-items-center">
        <button type="button" id="confirm" class="btn btn-dark btn-block mb-4" style="width: 120px;"><i class="fa-solid fa-check"></i> Confirm</button>
      </div>
    </div>
    <div class="col d-flex justify-content-start align-items-center">
      <label class="form-label" for="date2">&nbsp;</label>
      <div class="form-outline d-flex justify-content-center">
        <button type="button" id="export" class="btn btn-light mb-4 mb-lg-0" style="width: 120px;" disabled>
          <i class="fa-solid fa-table"></i> Export
        </button>
      </div>
    </div>
  </div>
</form>
<!-- form -->

         <table id="example" class="table table-striped" style="width:100%!important;font-size:16px;">
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
        <tbody>
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


    <!-- footer
<footer class="bg-dark text-center text-lg-start text-white" style="position:absolute;bottom:0;width:100%;">
<footer class="bg-dark text-center text-lg-start text-white" style="position:absolute;bottom:0;width:100%;"> -->
  <!-- Grid container 
  <div class="container p-4">
    Grid row
    <div class="row mt-4">-->
      <!--Grid column
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Contact Us</h5>

        <ul class="list-unstyled mb-0">
          <li>
          <i class="fa-solid fa-location-dot"></i> 19/1 ถนนเพชรเกษม เขตหนองแขม กรุงเทพ 10160
          </li>
          <li>
          <i class="fa-solid fa-phone"></i> 02-8074500 ต่อ 190, 192
          </li>
          <li>
          <i class="fa-solid fa-fax"></i> 02-8074528 – 30
          </li>
          <li>
          <i class="fa-solid fa-envelope"></i> info@sau.ac.th
          </li>
        </ul>
      </div>
      Grid column-->

      <!--Grid column
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Copyright <i class="fa-solid fa-copyright"></i></h5>
        <ul class="list-unstyled">
          <li>
          <i class="fa-brands fa-mdb"><a class="text-white" href="https://mdbootstrap.com/"></a></i> © 2021 by <a class="text-white">MDBootstrap.com</a>
          </li>
          <li>
          <a href="https://getbootstrap.com/" class="text-white"><i class="fa-brands fa-bootstrap"></i></a> © 2023 Company, Inc
          </li>
          <li>
            <a href="https://www.codehim.com/bootstrap/bootstrap-5-table-with-pagination-and-search-and-sorting/" class="text-white"> © 2023 by CodeHim Inc (Yolanda Goex)</a>
          </li>
          <li>
            <a href="https://codepen.io/wikyware-net/pens/" class="text-white">© 2023 by Wikyware Net</a>
          </li>
        </ul>
      </div>
      Grid column-->

      <!--Grid column
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Publishing house</h5>

        <ul class="list-unstyled">
          <li>
            <a href="#!" class="text-white">The BookStore</a>
          </li>
          <li>
            <a href="#!" class="text-white">123 Street</a>
          </li>
          <li>
            <a href="#!" class="text-white">05765 NY</a>
          </li>
          <li>
            <a href="#!" class="text-white"><i class="fas fa-briefcase fa-fw fa-sm me-2"></i>Send us a book</a>
          </li>
        </ul>
      </div>
      Grid column-->

      <!--Grid column
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Write to us</h5>

        <ul class="list-unstyled">
          <li>
            <a href="#!" class="text-white"><i class="fas fa-at fa-fw fa-sm me-2"></i>Help in purchasing</a>
          </li>
          <li>
            <a href="#!" class="text-white"><i class="fas fa-shipping-fast fa-fw fa-sm me-2"></i>Check the order status</a>
          </li>
          <li>
            <a href="#!" class="text-white"><i class="fas fa-envelope fa-fw fa-sm me-2"></i>Join the newsletter</a>
          </li>
        </ul>
      </div>
      Grid column-->
   <!-- </div>
    Grid row
</footer>
    footer -->
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



  // รับค่าเวลาเมื่อปุ่ม "Confirm" ถูกคลิก
  $("#confirm").on("click", function() {
    var table = $('#example').DataTable();
    table.destroy();//ต้องเคลียร์ทุกครั้งที่เรียกใช้ตาราง เพื่อเอาข้อมูลเก่าออกก่อน

    var startDate = $("#startDate").attr("data-date");
    var endDate = $("#endDate").attr("data-date");
    
    // แปลงรูปแบบ "dd/mm/yyyy" เป็น "yyyy-mm-dd"
    var Start_Date = formatDate_Table(startDate);
    var End_Date = formatDate_Table(endDate);

    // โหลดข้อมูลและใช้ .draw() เพื่ออัปเดต DataTable
    loadTableData(Start_Date, End_Date);
  });

  $("#export").on("click", function() {
    var startDate = $("#startDate").attr("data-date");
    var endDate = $("#endDate").attr("data-date");

    // Convert the date format from "dd/mm/yyyy" to "yyyy-mm-dd"
    var Start_Date = formatDate_Table(startDate);
    var End_Date = formatDate_Table(endDate);

    // Construct the export URL
    var exportUrl = './api/value_Sensor/api_exportExcel.php';
    exportUrl += "?start_date=" + Start_Date + "&end_date=" + End_Date;

    // Use the fetch API to download the Excel file (fetch) เป็น method  ที่ให้เราสามารถ รับ-ส่ง ข้อมูล (HTTP Request) ระหว่างเว็บได้จากเว็บบราวเซอร์ ตัว Fetch API จะ return ค่า Promise กลับมา
    fetch(exportUrl)
        .then(response => response.blob())
        .then(blob => {
            // Create a temporary URL for the blob
            var url = window.URL.createObjectURL(blob);

            // Create a temporary anchor element for downloading
            var a = document.createElement('a');
            a.href = url;
            a.download = 'exported_data.xlsx'; // Set the filename
            document.body.appendChild(a);
            a.click();

            // Cleanup
            window.URL.revokeObjectURL(url);//ทำการปิดหรือลบ URL ชั่วคราวเนื่องจากมันไม่จำเป็นแล้ว
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error("An error occurred while exporting the data:", error);
        });
});

  // ฟังก์ชันสำหรับโหลดข้อมูลและอัปเดต DataTable
  function loadTableData(startDate, endDate) {
    //ถ้า startDate เป็นค่าว่างหรือ null หรือ undefined จะกำหนดค่าเริ่มต้นให้เป็นสายอักขระว่าง (empty string) คือ ''.
    startDate = startDate || '';
    endDate = endDate || '';

    $.ajax({
      url: './api/value_Sensor/api_getValueTable.php',
      type: 'GET',
      data: {
        start_date: startDate,
        end_date: endDate
      },
      dataType: 'html', // ใช้ 'html' เนื่องจากข้อมูลที่ส่งกลับเป็น HTML ของตาราง
      success: function(data) {
        // อัปเดตข้อมูลใน DataTable
        if(data != ""){
          document.getElementById('export').disabled = false;
        }else{
          document.getElementById('export').disabled = true;
        }
        $('#example tbody').html(data);

        $('#example').DataTable({
      "searching": false, // Disable the search feature
      //disable sorting on last column
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ],
      language: {
        //customize pagination prev and next buttons: use arrows instead of words
        'paginate': {
          'previous': '<span class="fa fa-chevron-left"></span>',
          'next': '<span class="fa fa-chevron-right"></span>'
        },
        //customize number of elements to be displayed
        "lengthMenu": 'Display <select class="form-control input-sm">'+
        '<option value="10">10</option>'+
        '<option value="20">20</option>'+
        '<option value="30">30</option>'+
        '<option value="40">40</option>'+
        '<option value="50">50</option>'+
        '<option value="-1">All</option>'+
        '</select> results'
      }
    });
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาด:', error);
      }
    });
  }

  // ฟังก์ชันสำหรับแปลงรูปแบบ "dd/mm/yyyy" เป็น "yyyy-mm-dd"
  function formatDate_Table(date) {
    var dateParts = date.split('/');
    var year = dateParts[2];
    var month = dateParts[1];
    var day = dateParts[0];
    return year + '-' + month + '-' + day;
  }

</script>