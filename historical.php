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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
  <script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a561507f9a.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/Historical.js"></script>
  <title>Historical Data</title>
</head>
<style>
  /* เอาตัวเลือกจำนวน record ออก */
  .dataTables_length {
    display: none !important;
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

  <main class="cd__main" style="margin-top: 2%;">

    <!-- form -->
    <form id="myForm" class="rows gy-2 gx-3 align-items-center">
      <div class="row">
        <div class="col" id="widthDate">
          <label class="form-label" for="date2">Start Date</label>
          <div class="form-outline">
            <input type="date" id="startDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY">
          </div>
        </div>
        <div class="col" id="widthDate">
          <label class="form-label" for="date2">End Date</label>
          <div class="form-outline">
            <div>
              <input type="date" id="endDate" class="form-control" data-date="" data-date-format="DD/MM/YYYY">
            </div>
          </div>
        </div>
        <div class="col">
          <label class="form-label" for="date2">&nbsp;</label>
          <div class="form-outline d-flex justify-content-start align-items-center">
            <button type="button" id="confirm" class="btn btn-dark btn-block mb-4" style="width: 120px;"><i class="fa-solid fa-check"></i> Confirm</button>
          </div>
        </div>
        <div class="col">
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
          <th>AQI</th>
          <th>Date & Time</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <!-- END EDMO HTML (Happy Coding!)-->
  </main>


  <!-- Loader -->
  <div class="d-flex justify-content-center">
    <div class="spinner-border" id="Loader" role="status" style="display:none;">
    </div>
  </div>
  <!-- Loader -->


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
</body>

</html>
<script type="text/javascript">
  // ตรวจสอบว่าเป็น Firefox หรือไม่
  const isFirefox = navigator.userAgent.toLowerCase().includes('firefox');
  var Loader = document.getElementById('Loader');

  // ทำงานที่คุณต้องการทำในเบราว์เซอร์อื่น ๆ ที่ไม่ใช่ Firefox ที่นี่
  //date-picker
  document.getElementById('startDate').value = formatDate();
  document.getElementById('endDate').value = formatDate();

  $("#startDate").on("change", function() {
    this.setAttribute(
      "data-date",
      moment(this.value, "YYYY-MM-DD")
      .format(this.getAttribute("data-date-format"))
    )
  }).trigger("change")

  $("#endDate").on("change", function() {
    this.setAttribute(
      "data-date",
      moment(this.value, "YYYY-MM-DD")
      .format(this.getAttribute("data-date-format"))
    )
  }).trigger("change")

  function padTo2Digits(num) {
    return num.toString().padStart(2, '0'); //padStart(มี 2 ตำแหน่ง, เริ่มด้วย '0') Ex. '02'
  }

  function formatDate(date = new Date()) {
    return [
      date.getFullYear(),
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
    ].join('-');
  }



  // ฟังก์ชั่นที่จะทำงานเมื่อมีการเปลี่ยนแปลงขนาดหน้าจอ
  function handleScreenSizeChange(x) {
    var myForm = document.getElementById("myForm");

    if (x.matches) { // ถ้าขนาดหน้าจอน้อยกว่าหรือเท่ากับ 639px
      // เพิ่มคลาสให้กับ myForm
      myForm.classList.add("row", "gy-2", "gx-3", "align-items-center", "mx-auto", "justify-content-center");
    }
  }

  // สร้าง media query
  var x = window.matchMedia("(max-width: 639px)");

  // เรียกใช้ฟังก์ชั่นเพื่อตั้งค่าตอนเริ่มต้น
  handleScreenSizeChange(x);

  // แอ็ตและเพิ่ม Event Listener สำหรับการเปลี่ยนแปลงขนาดหน้าจอ
  x.addListener(handleScreenSizeChange);





  // รับค่าเวลาเมื่อปุ่ม "Confirm" ถูกคลิก
  $("#confirm").on("click", function() {
    Loader.style.display = "block";
    var table = $('#example').DataTable();
    table.destroy(); // ทำลายตารางเพื่อเอาข้อมูลเก่าออก
    table.clear().draw(); // ล้างข้อมูลในตาราง
    
    var startDate = $("#startDate").attr("data-date");
    var endDate = $("#endDate").attr("data-date");

    // แปลงรูปแบบ "dd/mm/yyyy" เป็น "yyyy-mm-dd"
    var Start_Date = formatDate_Table(startDate);
    var End_Date = formatDate_Table(endDate);

    if (new Date(Start_Date) > new Date(End_Date)) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'แจ้งเตือน ',
        html: 'ไม่สามารถเลือกวันที่เริ่มต้น มากกว่าวันที่สิ้นสุดได้',
        icon: 'info',
        confirmButtonText: 'OK'
      })
      loadTableData2(Start_Date, End_Date);

      document.getElementById('startDate').value = formatDate();
      document.getElementById('endDate').value = formatDate();

      $("#startDate").on("change", function() {
        this.setAttribute(
          "data-date",
          moment(this.value, "YYYY-MM-DD")
          .format(this.getAttribute("data-date-format"))
        )
      }).trigger("change")

      $("#endDate").on("change", function() {
        this.setAttribute(
          "data-date",
          moment(this.value, "YYYY-MM-DD")
          .format(this.getAttribute("data-date-format"))
        )
      }).trigger("change")

      function padTo2Digits(num) {
        return num.toString().padStart(2, '0'); //padStart(มี 2 ตำแหน่ง, เริ่มด้วย '0') Ex. '02'
      }

      function formatDate(date = new Date()) {
        return [
          date.getFullYear(),
          padTo2Digits(date.getMonth() + 1),
          padTo2Digits(date.getDate()),
        ].join('-');
      }
    } else {
      // โหลดข้อมูลและใช้ .draw() เพื่ออัปเดต DataTable
      loadTableData(Start_Date, End_Date);
    }
  });

  // สำหรับ Export Excel
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
        window.URL.revokeObjectURL(url); //ทำการปิดหรือลบ URL ชั่วคราวเนื่องจากมันไม่จำเป็นแล้ว
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
        if (data != "") {
          document.getElementById('export').disabled = false;
        } else {
          document.getElementById('export').disabled = true;

          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            title: 'แจ้งเตือน',
            html: 'วันที่เริ่มต้น และวันที่สิ้นสุดที่เลือกไม่มีข้อมูลในระบบ',
            icon: 'warning',
            confirmButtonText: 'OK'
          })

        }
        $('#example tbody').html(data);
        Loader.style.display = "none";
        $('#example').DataTable({
          "searching": false, // Disable the search feature
          //disable sorting on last column
          language: {
            //customize pagination prev and next buttons: use arrows instead of words
            'paginate': {
              'previous': '<span class="fa fa-chevron-left"></span>',
              'next': '<span class="fa fa-chevron-right"></span>'
            },
            //customize number of elements to be displayed
            // "lengthMenu": 'Display <select class="form-control input-sm">' +
            //   '<option value="10">10</option>' +
            //   '<option value="20">20</option>' +
            //   '<option value="30">30</option>' +
            //   '<option value="40">40</option>' +
            //   '<option value="50">50</option>' +
            //   '<option value="-1">All</option>' +
            //   '</select> results'
          }
        });
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาด:', error);
      }

    });
  }

  // ฟังก์ชันสำหรับโหลดข้อมูลว่าง
  function loadTableData2(startDate, endDate) {
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
        if (data != "") {
          document.getElementById('export').disabled = false;
        } else {
          document.getElementById('export').disabled = true;
        }
        $('#example tbody').html(data);

        $('#example').DataTable({
          "searching": false, // Disable the search feature
          //disable sorting on last column
          language: {
            //customize pagination prev and next buttons: use arrows instead of words
            'paginate': {
              'previous': '<span class="fa fa-chevron-left"></span>',
              'next': '<span class="fa fa-chevron-right"></span>'
            },
            //customize number of elements to be displayed
            "lengthMenu": 'Display <select class="form-control input-sm">' +
              '<option value="10">10</option>' +
              '<option value="20">20</option>' +
              '<option value="30">30</option>' +
              '<option value="40">40</option>' +
              '<option value="50">50</option>' +
              '<option value="-1">All</option>' +
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

  if (isFirefox) {
    document.getElementById('widthDate').style.width = "50px";
    flatpickr("#startDate, #endDate", {
      altInput: true,
      altFormat: "d/m/Y",
      dateFormat: "Y/m/d",
      onChange: function(selectedDates, dateStr, instance) {
        var altFormattedDate = moment(dateStr, "YYYY-MM-DD")
          .format(instance.input.getAttribute("data-date-format"));
        instance.altInput.value = altFormattedDate;
      }
    });
  } else {
    $("#startDate").on("change", function() {
      this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format(this.getAttribute("data-date-format"))
      )
    }).trigger("change")

    $("#endDate").on("change", function() {
      this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format(this.getAttribute("data-date-format"))
      )
    }).trigger("change")
  }
</script>