var Close_PM = document.getElementById('Close_PM');
var Close_Temp = document.getElementById('Close_Temp');
var Close_Humid = document.getElementById('Close_Humid');
var Close_Speed = document.getElementById('Close_Speed');
var Close_Pressure = document.getElementById('Close_Pressure');
var Close_Direction = document.getElementById('Close_Direction'); 
var ddlChart = document.getElementById('ddlChart'); 
var Check = document.getElementById("flexSwitchCheckDefault");
var Loader = document.getElementById("loader");

const ctx = document.getElementById('myChart').getContext('2d');
var myChart;//สร้างตัวแปร myChart นอกฟังก์ชันเพื่อให้เป็น global scope ถ้าไม่สร้างจะกดปุ่ม call funtion ไม่ได้
  function values() {
    $.ajax({
        url: './api/value_Sensor/api_getValueSensor_Chart.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          const readingTimes = data.map(item => {
            const dateTimeParts = item.Reading_Time.split(' ');
            const dateParts = dateTimeParts[0].split('-');
            const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
            const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
            const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
            const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
            return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
        });
        const PM = data.map(item => parseInt(item.PM)); // แปลงค่า PM เป็นตัวเลขและนำมาใส่ในอาเรย์ จาก JSON โดยใช้ obj item เพื่อเข้าถึง Values
        myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: readingTimes, // time
            datasets: [
              {
                data: PM,
                backgroundColor: "#f9b234",
                borderColor: "#f9b234",
                borderWidth: 3,
                yAxisID: 'y'
              },
            ],
          },
          options: {
            responsive: true,
            interaction: {
              mode: 'index',
              intersect: false,
            },
            stacked: true,
            plugins: {
              title: {
                display: true,
                //text: 'Chart PM2.5 Value',
                font: {
                  size: 17,
                  weight: 'bold',
                  family: 'Itim',
                },
              },
              legend: {
                display: false,
              },
            },
            scales: {
              x: {
                ticks: {
                  maxRotation: 0, // ป้องกันการหมุนแท็ก
                  font: {
                    weight: 'bold',
                  },
                },
              },
              y: {
                type: 'linear',
                display: true,
                position: 'left',
                ticks: {
                  font: {
                    weight: 'bold',
                  },
                },
              },
            },
            elements: {
              line: {
                tension: 0.4, // ปรับค่านี้เพื่อควบคุมการโค้งของเส้นกราฟ
              },
            },
            maintainAspectRatio: false,
          },
        });
        }
    });
   }
   values();
   Chart_PM(1);
   
var PM_Interval;
var Temp_Interval;
var Humid_Interval;
var Pressure_Interval;
var Speed_Interval;
var Direction_Interval;
var AQI_Interval;
var Compare_Interval;


function Chart_PM(stop){
    if(stop == 1){
      if(Check.checked == false){
        clearInterval(PM_Interval);
        PM_Interval = setInterval(PM, 3000); 
        PM();
    }else{
      for (let i = 1; i < 7; i++) {
        myChart.data.datasets.pop();
      }
      // clearInterval(Compare_Interval);
      Chked();
    }
    }else{
      clearInterval(PM_Interval);
    }
  
    function PM(){
      $.ajax({
        url: './api/value_Sensor/api_getValueSensor_Chart.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          const readingTimes = data.map(item => {
            const dateTimeParts = item.Reading_Time.split(' ');
            const dateParts = dateTimeParts[0].split('-');
            const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
            const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
            const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
            const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
            return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
        });
        const PM = data.map(item => item.PM !== null ? parseInt(item.PM) : 0);
          //myChart.options.plugins.title.text = "Chart PM2.5 Value";
          myChart.data.labels = readingTimes;
          myChart.data.datasets[0].data = PM;
          myChart.data.datasets[0].backgroundColor = "#f9b234";
          myChart.data.datasets[0].borderColor = "#f9b234";
          myChart.update();
          ddlChart.value = 0;
          ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#f9b234";             
        }
    });
    }
}

function Chart_Temp(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(Temp_Interval);
    Temp_Interval = setInterval(Temp, 3000); 
  Temp();
}else{
  for (let i = 1; i < 7; i++) {
    myChart.data.datasets.pop();
  }
  // clearInterval(Compare_Interval);
  Chked();
}
  }else{
    clearInterval(Temp_Interval);
  }

  function Temp(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const Temperature = data.map(item => item.Temperature !== null ? parseFloat(item.Temperature).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart Temperature Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Temperature;
        myChart.data.datasets[0].backgroundColor = "#3ecd5e";
        myChart.data.datasets[0].borderColor = "#3ecd5e";
        myChart.update();
        ddlChart.value = 2;
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#3ecd5e"; 
      }
  });
  }
}

function Chart_Humid(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(Humid_Interval);
    Humid_Interval = setInterval(Humid, 3000); 
    Humid();
  }else{
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    // clearInterval(Compare_Interval);
    Chked();
  }
  }else{
    clearInterval(Humid_Interval);
  }
 
  function Humid(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const Humidity = data.map(item => item.Humidity !== null ? parseFloat(item.Humidity).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart Humidity Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Humidity;
        myChart.data.datasets[0].backgroundColor = "#e44002";
        myChart.data.datasets[0].borderColor = "#e44002";
        myChart.update();
        ddlChart.value = 3;
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#e44002"; 
    }
  });
  }
}

function Chart_Pressure(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(Pressure_Interval);
    Pressure_Interval = setInterval(Pressure, 3000); 
    Pressure();
  }else{
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    // clearInterval(Compare_Interval);
    Chked();
  }
  }else{
    clearInterval(Pressure_Interval);
  } 

  function Pressure(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const Air_Pressure = data.map(item => item.Air_Pressure !== null ? parseFloat(item.Air_Pressure).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart Air Pressure Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Air_Pressure;
        myChart.data.datasets[0].backgroundColor = "#952aff";
        myChart.data.datasets[0].borderColor = "#952aff";
        myChart.update();
        ddlChart.value = 4;
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#952aff";  
      }
  });
  }
}

function Chart_Speed(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(Speed_Interval);
    Speed_Interval = setInterval(Speed, 3000); 
    Speed();
  }else{
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    // clearInterval(Compare_Interval);
    Chked();
  }
  }else{
    clearInterval(Speed_Interval);
  } 
  function Speed(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const Wind_Speed = data.map(item => item.Wind_Speed !== null ? parseFloat(item.Wind_Speed).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart Wind Speed Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Speed;
        myChart.data.datasets[0].backgroundColor = "#cd3e94";
        myChart.data.datasets[0].borderColor = "#cd3e94";
        myChart.update(); 
        ddlChart.value = 5;    
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#cd3e94";   
      }
  });
  }
}

function Chart_Direction(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(Direction_Interval);
    Direction_Interval = setInterval(Direction, 3000); 
    Direction();
  }else{
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    // clearInterval(Compare_Interval);
    Chked();
  }
  }else{
    clearInterval(Direction_Interval);
  } 
  function Direction(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const Wind_Direction = data.map(item => item.Wind_Direction !== null ? parseFloat(item.Wind_Direction).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart Wind Direction Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Direction;
        myChart.data.datasets[0].backgroundColor = "#4c49ea";
        myChart.data.datasets[0].borderColor = "#4c49ea";
        myChart.update();
        ddlChart.value = 6;
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#4c49ea";
      }
  });
  }
}

function Chart_AQI(stop){
  if(stop == 1){
    if(Check.checked == false){
    clearInterval(AQI_Interval);
    AQI_Interval = setInterval(AQI, 3000); 
    AQI();
  }else{
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    // clearInterval(Compare_Interval);
    Chked();
  }
  }else{
    clearInterval(AQI_Interval);
  } 
  function AQI(){
    $.ajax({
      url: './api/value_Sensor/api_getValueSensor_Chart.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const dateTimeParts = item.Reading_Time.split(' ');
          const dateParts = dateTimeParts[0].split('-');
          const yearTH = String((parseInt(dateParts[0])+543)).slice(-2);
          const dateTH = `${dateParts[2]}-${dateParts[1]}-${yearTH}`;//เรียง dd-MM-yyy
          const dateTH2 = dateTH.replace(/-/g, '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
      const AQI = data.map(item => item.AQI !== null ? parseFloat(item.AQI).toFixed(2) : 0);
        //myChart.options.plugins.title.text = "Chart AQI Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = AQI;
        myChart.data.datasets[0].backgroundColor = "#000000";
        myChart.data.datasets[0].borderColor = "#000000";
        myChart.update();
        ddlChart.value = 1;
        ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#000000";
      }
  });
  }
}

function ddlChange(){
  var selected = ddlChart.value;
  //console.log(selected);
  if(selected == 1){
      Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(1);
  }else if(selected == 2){
      Chart_PM(0);Chart_Temp(1);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  }else if(selected == 3){
      Chart_PM(0);Chart_Temp(0);Chart_Humid(1);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  }else if(selected == 4){
      Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(1);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  }else if(selected == 5){
      Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(1);Chart_Direction(0);Chart_AQI(0);
  }else if(selected == 6){
      Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(1);Chart_AQI(0);  
  }else{
      Chart_PM(1);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  }
}

function Compare(){
  if(Check.checked == true){
    var Today;
    var Day2;
    var Day3;
    var Day4;
    var Day5;
    var Day6;
    var Day7;
    $.ajax({
      url: './api/value_Sensor/api_getDayCompare.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        const readingTimes = data.map(item => {
          const TimePart = item.Reading_Time;
          return TimePart;
      });
    
         Today = data.map(item => (item.Today));
         Day2 = data.map(item => (item.Day2));
         Day3 = data.map(item => (item.Day3));
         Day4 = data.map(item => (item.Day4));
         Day5 = data.map(item => (item.Day5));
         Day6 = data.map(item => (item.Day6));
         Day7 = data.map(item => (item.Day7));

      }
    });

if(ddlChart.value == 0){
  
      ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#f9b234";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  $.ajax({
    url: './api/value_Sensor/api_getPMChartCompare.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      const readingTimes = data.map(item => {
        const TimePart = item.Reading_Time;
        return TimePart;
    });

    const numberOfDatasets = myChart.data.datasets.length;
    const PM1 = data.map(item => item.PM1 !== null ? parseInt(item.PM1) : 0);
    const PM2 = data.map(item => item.PM2 !== null ? parseInt(item.PM2) : 0);
    const PM3 = data.map(item => item.PM3 !== null ? parseInt(item.PM3) : 0);
    const PM4 = data.map(item => item.PM4 !== null ? parseInt(item.PM4) : 0);
    const PM5 = data.map(item => item.PM5 !== null ? parseInt(item.PM5) : 0);
    const PM6 = data.map(item => item.PM6 !== null ? parseInt(item.PM6) : 0);
    const PM7 = data.map(item => item.PM7 !== null ? parseInt(item.PM7) : 0);
    

    if(numberOfDatasets == 1 ){
      if (Check.checked == true) {
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = PM1;      
        myChart.data.datasets.push({
          data: PM2,
          backgroundColor: "#03045e",
          borderColor: "#03045e",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: PM3,
          backgroundColor: "#262d79",
          borderColor: "#262d79",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: PM4,
          backgroundColor: "#475492",
          borderColor: "#475492",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: PM5,
          backgroundColor: "#677bab",
          borderColor: "#677bab",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: PM6,
          backgroundColor: "#88a2c4",
          borderColor: "#88a2c4",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: PM7,
          backgroundColor: "#a9c9dd",
          borderColor: "#a9c9dd",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.options.plugins.legend = {
          display: true,
          labels: {
              generateLabels: function(chart) {
                  return [
                      { text: 'Today', fillStyle: '#f9b234' },
                      { text: Day2, fillStyle: '#03045e' },
                      { text: Day3, fillStyle: '#262d79' },
                      { text: Day4, fillStyle: '#475492' },
                      { text: Day5, fillStyle: '#677bab' },
                      { text: Day6, fillStyle: '#88a2c4' },
                      { text: Day7, fillStyle: '#a9c9dd' }
                  ];
              }
          }
      };Check.disabled = false;
      Loader.style.visibility = "hidden";
      }
    }else{
      myChart.data.labels = readingTimes;
      myChart.data.datasets[0].data = PM1;
      myChart.data.datasets[1].data = PM2;
      myChart.data.datasets[2].data = PM3;
      myChart.data.datasets[3].data = PM4;
      myChart.data.datasets[4].data = PM5;
      myChart.data.datasets[5].data = PM6;
      myChart.data.datasets[6].data = PM7;
    }
    Check.disabled = false;
    Loader.style.visibility = "hidden";
    myChart.data.datasets[0].borderWidth = 6;
    myChart.data.datasets[0].backgroundColor = "#f9b234";
    myChart.data.datasets[0].borderColor = "#f9b234";
    myChart.update();
  }
});
}

else if(ddlChart.value == 1){
  ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#000000";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
$.ajax({
url: './api/value_Sensor/api_getAQIChartCompare.php',
type: 'GET',
dataType: 'json',
success: function(data) {
  const readingTimes = data.map(item => {
    const TimePart = item.Reading_Time;
    return TimePart;
});
const numberOfDatasets = myChart.data.datasets.length;
const AQI1 = data.map(item => item.AQI1 !== null ? parseFloat(item.AQI1) : 0);
const AQI2 = data.map(item => item.AQI2 !== null ? parseFloat(item.AQI2) : 0);
const AQI3 = data.map(item => item.AQI3 !== null ? parseFloat(item.AQI3) : 0);
const AQI4 = data.map(item => item.AQI4 !== null ? parseFloat(item.AQI4) : 0);
const AQI5 = data.map(item => item.AQI5 !== null ? parseFloat(item.AQI5) : 0);
const AQI6 = data.map(item => item.AQI6 !== null ? parseFloat(item.AQI6) : 0);
const AQI7 = data.map(item => item.AQI7 !== null ? parseFloat(item.AQI7) : 0);


if(numberOfDatasets == 1){
  if (Check.checked == true) {
    myChart.data.labels = readingTimes;
    myChart.data.datasets[0].data = AQI1;
    myChart.data.datasets.push({
      data: AQI2,
      backgroundColor: "#03045e",
      borderColor: "#03045e",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: AQI3,
      backgroundColor: "#262d79",
      borderColor: "#262d79",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: AQI4,
      backgroundColor: "#475492",
      borderColor: "#475492",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: AQI5,
      backgroundColor: "#677bab",
      borderColor: "#677bab",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: AQI6,
      backgroundColor: "#88a2c4",
      borderColor: "#88a2c4",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: AQI7,
      backgroundColor: "#a9c9dd",
      borderColor: "#a9c9dd",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.options.plugins.legend = {
      display: true,
      labels: {
          generateLabels: function(chart) {
              return [
                  { text: 'Today', fillStyle: '#000000' },
                  { text: Day2, fillStyle: '#03045e' },
                  { text: Day3, fillStyle: '#262d79' },
                  { text: Day4, fillStyle: '#475492' },
                  { text: Day5, fillStyle: '#677bab' },
                  { text: Day6, fillStyle: '#88a2c4' },
                  { text: Day7, fillStyle: '#a9c9dd' }
              ];
          }
      }
  };Check.disabled = false;
  Loader.style.visibility = "hidden";
  }
}else{
  myChart.data.labels = readingTimes;
  myChart.data.datasets[0].data = AQI1;
  myChart.data.datasets[1].data = AQI2;
  myChart.data.datasets[2].data = AQI3;
  myChart.data.datasets[3].data = AQI4;
  myChart.data.datasets[4].data = AQI5;
  myChart.data.datasets[5].data = AQI6;
  myChart.data.datasets[6].data = AQI7;
}
Check.disabled = false;
Loader.style.visibility = "hidden";
myChart.data.datasets[0].backgroundColor = "#000000";
myChart.data.datasets[0].borderColor = "#000000";
myChart.data.datasets[0].borderWidth = 6;
myChart.update();
}
});
}


else if(ddlChart.value == 2){
  ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#3ecd5e";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
$.ajax({
url: './api/value_Sensor/api_getTempChartCompare.php',
type: 'GET',
dataType: 'json',
success: function(data) {
  const readingTimes = data.map(item => {
    const TimePart = item.Reading_Time;
    return TimePart;
});
const numberOfDatasets = myChart.data.datasets.length;
const Temp1 = data.map(item => item.Temp1 !== null ? parseFloat(item.Temp1) : 0);
const Temp2 = data.map(item => item.Temp2 !== null ? parseFloat(item.Temp2) : 0);
const Temp3 = data.map(item => item.Temp3 !== null ? parseFloat(item.Temp3) : 0);
const Temp4 = data.map(item => item.Temp4 !== null ? parseFloat(item.Temp4) : 0);
const Temp5 = data.map(item => item.Temp5 !== null ? parseFloat(item.Temp5) : 0);
const Temp6 = data.map(item => item.Temp6 !== null ? parseFloat(item.Temp6) : 0);
const Temp7 = data.map(item => item.Temp7 !== null ? parseFloat(item.Temp7) : 0);


if(numberOfDatasets == 1){
 if (Check.checked == true) {
   myChart.data.labels = readingTimes;
   myChart.data.datasets[0].data = Temp1;
   myChart.data.datasets[0].backgroundColor = "#3ecd5e";
   myChart.data.datasets[0].borderColor = "#3ecd5e";
   myChart.data.datasets[0].borderWidth = 6;
   myChart.data.datasets.push({
     data: Temp2,
     backgroundColor: "#03045e",
     borderColor: "#03045e",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.data.datasets.push({
     data: Temp3,
     backgroundColor: "#262d79",
     borderColor: "#262d79",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.data.datasets.push({
     data: Temp4,
     backgroundColor: "#475492",
     borderColor: "#475492",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.data.datasets.push({
     data: Temp5,
     backgroundColor: "#677bab",
     borderColor: "#677bab",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.data.datasets.push({
     data: Temp6,
     backgroundColor: "#88a2c4",
     borderColor: "#88a2c4",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.data.datasets.push({
     data: Temp7,
     backgroundColor: "#a9c9dd",
     borderColor: "#a9c9dd",
     borderWidth: 3,
     yAxisID: 'y'
   });
   myChart.options.plugins.legend = {
     display: true,
     labels: {
         generateLabels: function(chart) {
             return [
                 { text: 'Today', fillStyle: '#3ecd5e' },
                 { text: Day2, fillStyle: '#03045e' },
                 { text: Day3, fillStyle: '#262d79' },
                 { text: Day4, fillStyle: '#475492' },
                 { text: Day5, fillStyle: '#677bab' },
                 { text: Day6, fillStyle: '#88a2c4' },
                 { text: Day7, fillStyle: '#a9c9dd' }
             ];
         }
     }
 };Check.disabled = false;
 Loader.style.visibility = "hidden";
 }
}else{
  myChart.data.labels = readingTimes;
  myChart.data.datasets[0].data = Temp1;
  myChart.data.datasets[1].data = Temp2;
  myChart.data.datasets[2].data = Temp3;
  myChart.data.datasets[3].data = Temp4;
  myChart.data.datasets[4].data = Temp5;
  myChart.data.datasets[5].data = Temp6;
  myChart.data.datasets[6].data = Temp7;
}
Check.disabled = false;
Loader.style.visibility = "hidden";
myChart.data.datasets[0].backgroundColor = "#3ecd5e";
myChart.data.datasets[0].borderColor = "#3ecd5e";
myChart.data.datasets[0].borderWidth = 6;
myChart.update();
}
});
}


else if(ddlChart.value == 3){
  ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#e44002";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
$.ajax({
url: './api/value_Sensor/api_getHumidChartCompare.php',
type: 'GET',
dataType: 'json',
success: function(data) {
  const readingTimes = data.map(item => {
    const TimePart = item.Reading_Time;
    return TimePart;
});
const numberOfDatasets = myChart.data.datasets.length;
const Humid1 = data.map(item => item.Humid1 !== null ? parseFloat(item.Humid1) : 0);
const Humid2 = data.map(item => item.Humid2 !== null ? parseFloat(item.Humid2) : 0);
const Humid3 = data.map(item => item.Humid3 !== null ? parseFloat(item.Humid3) : 0);
const Humid4 = data.map(item => item.Humid4 !== null ? parseFloat(item.Humid4) : 0);
const Humid5 = data.map(item => item.Humid5 !== null ? parseFloat(item.Humid5) : 0);
const Humid6 = data.map(item => item.Humid6 !== null ? parseFloat(item.Humid6) : 0);
const Humid7 = data.map(item => item.Humid7 !== null ? parseFloat(item.Humid7) : 0);

if(numberOfDatasets == 1){
  if (Check.checked == true) {
    myChart.data.labels = readingTimes;
    myChart.data.datasets[0].data = Humid1;
    myChart.data.datasets[0].backgroundColor = "#e44002";
    myChart.data.datasets[0].borderColor = "#e44002";
    myChart.data.datasets[0].borderWidth = 6;
    myChart.data.datasets.push({
      data: Humid2,
      backgroundColor: "#03045e",
      borderColor: "#03045e",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Humid3,
      backgroundColor: "#262d79",
      borderColor: "#262d79",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Humid4,
      backgroundColor: "#475492",
      borderColor: "#475492",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Humid5,
      backgroundColor: "#677bab",
      borderColor: "#677bab",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Humid6,
      backgroundColor: "#88a2c4",
      borderColor: "#88a2c4",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Humid7,
      backgroundColor: "#a9c9dd",
      borderColor: "#a9c9dd",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.options.plugins.legend = {
      display: true,
      labels: {
          generateLabels: function(chart) {
              return [
                  { text: 'Today', fillStyle: '#e44002' },
                  { text: Day2, fillStyle: '#03045e' },
                  { text: Day3, fillStyle: '#262d79' },
                  { text: Day4, fillStyle: '#475492' },
                  { text: Day5, fillStyle: '#677bab' },
                  { text: Day6, fillStyle: '#88a2c4' },
                  { text: Day7, fillStyle: '#a9c9dd' }
              ];
          }
      }
  };Check.disabled = false;
  Loader.style.visibility = "hidden";
  }
}else{
  myChart.data.labels = readingTimes;
  myChart.data.datasets[0].data = Humid1;
  myChart.data.datasets[1].data = Humid2;
  myChart.data.datasets[2].data = Humid3;
  myChart.data.datasets[3].data = Humid4;
  myChart.data.datasets[4].data = Humid5;
  myChart.data.datasets[5].data = Humid6;
  myChart.data.datasets[6].data = Humid7;
}
Check.disabled = false;
Loader.style.visibility = "hidden";
myChart.data.datasets[0].backgroundColor = "#e44002";
myChart.data.datasets[0].borderColor = "#e44002";
myChart.data.datasets[0].borderWidth = 6;
myChart.update();
}
});
}


else if(ddlChart.value == 4){
  ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#952aff";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
$.ajax({
url: './api/value_Sensor/api_getAirPressureChartCompare.php',
type: 'GET',
dataType: 'json',
success: function(data) {
  const readingTimes = data.map(item => {
    const TimePart = item.Reading_Time;
    return TimePart;
});
const numberOfDatasets = myChart.data.datasets.length;
const Air_Pressure1 = data.map(item => item.Air_Pressure1 !== null ? parseFloat(item.Air_Pressure1) : 0);
const Air_Pressure2 = data.map(item => item.Air_Pressure2 !== null ? parseFloat(item.Air_Pressure2) : 0);
const Air_Pressure3 = data.map(item => item.Air_Pressure3 !== null ? parseFloat(item.Air_Pressure3) : 0);
const Air_Pressure4 = data.map(item => item.Air_Pressure4 !== null ? parseFloat(item.Air_Pressure4) : 0);
const Air_Pressure5 = data.map(item => item.Air_Pressure5 !== null ? parseFloat(item.Air_Pressure5) : 0);
const Air_Pressure6 = data.map(item => item.Air_Pressure6 !== null ? parseFloat(item.Air_Pressure6) : 0);
const Air_Pressure7 = data.map(item => item.Air_Pressure7 !== null ? parseFloat(item.Air_Pressure7) : 0);


if(numberOfDatasets == 1){
  if (Check.checked == true) {
    myChart.data.labels = readingTimes;
    myChart.data.datasets[0].data = Air_Pressure1;
    myChart.data.datasets.push({
      data: Air_Pressure2,
      backgroundColor: "#03045e",
      borderColor: "#03045e",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Air_Pressure3,
      backgroundColor: "#262d79",
      borderColor: "#262d79",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Air_Pressure4,
      backgroundColor: "#475492",
      borderColor: "#475492",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Air_Pressure5,
      backgroundColor: "#677bab",
      borderColor: "#677bab",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Air_Pressure6,
      backgroundColor: "#88a2c4",
      borderColor: "#88a2c4",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.data.datasets.push({
      data: Air_Pressure7,
      backgroundColor: "#a9c9dd",
      borderColor: "#a9c9dd",
      borderWidth: 3,
      yAxisID: 'y'
    });
    myChart.options.plugins.legend = {
      display: true,
      labels: {
          generateLabels: function(chart) {
              return [
                  { text: 'Today', fillStyle: '#952aff' },
                  { text: Day2, fillStyle: '#03045e' },
                  { text: Day3, fillStyle: '#262d79' },
                  { text: Day4, fillStyle: '#475492' },
                  { text: Day5, fillStyle: '#677bab' },
                  { text: Day6, fillStyle: '#88a2c4' },
                  { text: Day7, fillStyle: '#a9c9dd' }
              ];
          }
      }
  };Check.disabled = false;
  Loader.style.visibility = "hidden";
  }
}else{
  myChart.data.labels = readingTimes;
  myChart.data.datasets[0].data = Air_Pressure1;
  myChart.data.datasets[1].data = Air_Pressure2;
  myChart.data.datasets[2].data = Air_Pressure3;
  myChart.data.datasets[3].data = Air_Pressure4;
  myChart.data.datasets[4].data = Air_Pressure5;
  myChart.data.datasets[5].data = Air_Pressure6;
  myChart.data.datasets[6].data = Air_Pressure7;
}
Check.disabled = false;
Loader.style.visibility = "hidden";
myChart.data.datasets[0].backgroundColor = "#952aff";
myChart.data.datasets[0].borderColor = "#952aff";
myChart.data.datasets[0].borderWidth = 6;
myChart.update();
}
});
}

else if(ddlChart.value == 5){
  ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#cd3e94";
  Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
  $.ajax({
    url: './api/value_Sensor/api_getWindSpeedChartCompare.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      const readingTimes = data.map(item => {
        const TimePart = item.Reading_Time;
        return TimePart;
    });
    const numberOfDatasets = myChart.data.datasets.length;
    const Wind_Speed1 = data.map(item => item.Wind_Speed1 !== null ? parseFloat(item.Wind_Speed1) : 0);
    const Wind_Speed2 = data.map(item => item.Wind_Speed2 !== null ? parseFloat(item.Wind_Speed2) : 0);
    const Wind_Speed3 = data.map(item => item.Wind_Speed3 !== null ? parseFloat(item.Wind_Speed3) : 0);
    const Wind_Speed4 = data.map(item => item.Wind_Speed4 !== null ? parseFloat(item.Wind_Speed4) : 0);
    const Wind_Speed5 = data.map(item => item.Wind_Speed5 !== null ? parseFloat(item.Wind_Speed5) : 0);
    const Wind_Speed6 = data.map(item => item.Wind_Speed6 !== null ? parseFloat(item.Wind_Speed6) : 0);
    const Wind_Speed7 = data.map(item => item.Wind_Speed7 !== null ? parseFloat(item.Wind_Speed7) : 0);
    

    if(numberOfDatasets == 1){
      if (Check.checked == true) {
        myChart.data.labels = readingTimes;   
        myChart.data.datasets[0].data = Wind_Speed1;
        myChart.data.datasets.push({
          data: Wind_Speed2,
          backgroundColor: "#03045e",
          borderColor: "#03045e",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: Wind_Speed3,
          backgroundColor: "#262d79",
          borderColor: "#262d79",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: Wind_Speed4,
          backgroundColor: "#475492",
          borderColor: "#475492",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: Wind_Speed5,
          backgroundColor: "#677bab",
          borderColor: "#677bab",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: Wind_Speed6,
          backgroundColor: "#88a2c4",
          borderColor: "#88a2c4",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.data.datasets.push({
          data: Wind_Speed7,
          backgroundColor: "#a9c9dd",
          borderColor: "#a9c9dd",
          borderWidth: 3,
          yAxisID: 'y'
        });
        myChart.options.plugins.legend = {
          display: true,
          labels: {
              generateLabels: function(chart) {
                  return [
                      { text: 'Today', fillStyle: '#cd3e94' },
                      { text: Day2, fillStyle: '#03045e' },
                      { text: Day3, fillStyle: '#262d79' },
                      { text: Day4, fillStyle: '#475492' },
                      { text: Day5, fillStyle: '#677bab' },
                      { text: Day6, fillStyle: '#88a2c4' },
                      { text: Day7, fillStyle: '#a9c9dd' }
                  ];
              }
          }
      };Check.disabled = false;
      Loader.style.visibility = "hidden";
      }
  }else{
    myChart.data.labels = readingTimes;
    myChart.data.datasets[0].data = Wind_Speed1;
    myChart.data.datasets[1].data = Wind_Speed2;
    myChart.data.datasets[2].data = Wind_Speed3;
    myChart.data.datasets[3].data = Wind_Speed4;
    myChart.data.datasets[4].data = Wind_Speed5;
    myChart.data.datasets[5].data = Wind_Speed6;
    myChart.data.datasets[6].data = Wind_Speed7;
  }
  Check.disabled = false;
  Loader.style.visibility = "hidden";
  myChart.data.datasets[0].backgroundColor = "#cd3e94";
  myChart.data.datasets[0].borderColor = "#cd3e94";
  myChart.data.datasets[0].borderWidth = 6;
  myChart.update();
  }
    });
    }


else if(ddlChart.value == 6){
      ddlChart.style = "width:auto; font-weight:blod;background-color:black;color:white;border-radius:20px;background-color:#4c49ea";
      Chart_PM(0);Chart_Temp(0);Chart_Humid(0);Chart_Pressure(0);Chart_Speed(0);Chart_Direction(0);Chart_AQI(0);
      $.ajax({
        url: './api/value_Sensor/api_getWindDirectionChartCompare.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          const readingTimes = data.map(item => {
            const TimePart = item.Reading_Time;
            return TimePart;
        });
        const numberOfDatasets = myChart.data.datasets.length;
        const Wind_Direction1 = data.map(item => item.Wind_Direction1 !== null ? parseFloat(item.Wind_Direction1) : 0);
        const Wind_Direction2 = data.map(item => item.Wind_Direction2 !== null ? parseFloat(item.Wind_Direction2) : 0);
        const Wind_Direction3 = data.map(item => item.Wind_Direction3 !== null ? parseFloat(item.Wind_Direction3) : 0);
        const Wind_Direction4 = data.map(item => item.Wind_Direction4 !== null ? parseFloat(item.Wind_Direction4) : 0);
        const Wind_Direction5 = data.map(item => item.Wind_Direction5 !== null ? parseFloat(item.Wind_Direction5) : 0);
        const Wind_Direction6 = data.map(item => item.Wind_Direction6 !== null ? parseFloat(item.Wind_Direction6) : 0);
        const Wind_Direction7 = data.map(item => item.Wind_Direction7 !== null ? parseFloat(item.Wind_Direction7) : 0);        

        if(numberOfDatasets == 1){
          if (Check.checked == true) {
            myChart.data.labels = readingTimes;
            myChart.data.datasets[0].data = Wind_Direction1;
            myChart.data.datasets.push({
              data: Wind_Direction2,
              backgroundColor: "#03045e",
              borderColor: "#03045e",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.data.datasets.push({
              data: Wind_Direction3,
              backgroundColor: "#262d79",
              borderColor: "#262d79",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.data.datasets.push({
              data: Wind_Direction4,
              backgroundColor: "#475492",
              borderColor: "#475492",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.data.datasets.push({
              data: Wind_Direction5,
              backgroundColor: "#677bab",
              borderColor: "#677bab",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.data.datasets.push({
              data: Wind_Direction6,
              backgroundColor: "#88a2c4",
              borderColor: "#88a2c4",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.data.datasets.push({
              data: Wind_Direction7,
              backgroundColor: "#a9c9dd",
              borderColor: "#a9c9dd",
              borderWidth: 3,
              yAxisID: 'y'
            });
            myChart.options.plugins.legend = {
              display: true,
              labels: {
                  generateLabels: function(chart) {
                      return [
                          { text: 'Today', fillStyle: '#4c49ea' },
                          { text: Day2, fillStyle: '#03045e' },
                          { text: Day3, fillStyle: '#262d79' },
                          { text: Day4, fillStyle: '#475492' },
                          { text: Day5, fillStyle: '#677bab' },
                          { text: Day6, fillStyle: '#88a2c4' },
                          { text: Day7, fillStyle: '#a9c9dd' }
                      ];
                  }
              }
          };Check.disabled = false;
          Loader.style.visibility = "hidden";
          }
      }else{
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Direction1;
        myChart.data.datasets[1].data = Wind_Direction2;
        myChart.data.datasets[2].data = Wind_Direction3;
        myChart.data.datasets[3].data = Wind_Direction4;
        myChart.data.datasets[4].data = Wind_Direction5;
        myChart.data.datasets[5].data = Wind_Direction6;
        myChart.data.datasets[6].data = Wind_Direction7;
      }
      Check.disabled = false;
      Loader.style.visibility = "hidden";
      myChart.data.datasets[0].backgroundColor = "#4c49ea";
      myChart.data.datasets[0].borderColor = "#4c49ea";
      myChart.data.datasets[0].borderWidth = 6;
      myChart.update();
      }
        });
        }

}else{
    // ลบ Legend พวก Today ,....
    myChart.options.plugins.legend = {
      display: false
  };
  // clearInterval(Compare_Interval);
  // ลบ datasets ที่เพิ่มเข้าไปล่าสุดออกจากอาร์เรย์
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    myChart.data.datasets[0].borderWidth = 3;
    if(ddlChart.value == 0){
      Chart_PM(1);
    }
    else if(ddlChart.value == 1){
      Chart_AQI(1);
    }
    else if(ddlChart.value == 2){
      Chart_Temp(1);
    }
    else if(ddlChart.value == 3){
      Chart_Humid(1);
    }
    else if(ddlChart.value == 4){
      Chart_Pressure(1);
    }
    else if(ddlChart.value == 5){
      Chart_Speed(1);
    }
    else if(ddlChart.value == 6){
      Chart_Direction(1);
    }
    // อัปเดตกราฟ
    myChart.update();
}
}

function Chked(){
  if(Check.checked == true){
    Check.disabled = true;
    Loader.style.visibility = "visible";
    clearInterval(Compare_Interval);
    Compare_Interval = setInterval(Compare, 3000); 
    Compare();
}else{
  Check.disabled = false;
  Loader.style.visibility = "hidden";
      // ลบ Legend พวก Today ,....
      myChart.options.plugins.legend = {
        display: false
    };
  clearInterval(Compare_Interval);
  // ลบ datasets ที่เพิ่มเข้าไปล่าสุดออกจากอาร์เรย์
    for (let i = 1; i < 7; i++) {
      myChart.data.datasets.pop();
    }
    myChart.data.datasets[0].borderWidth = 3;
    if(ddlChart.value == 0){
      Chart_PM(1);
    }
    else if(ddlChart.value == 1){
      Chart_AQI(1);
    }
    else if(ddlChart.value == 2){
      Chart_Temp(1);
    }
    else if(ddlChart.value == 3){
      Chart_Humid(1);
    }
    else if(ddlChart.value == 4){
      Chart_Pressure(1);
    }
    else if(ddlChart.value == 5){
      Chart_Speed(1);
    }
    else if(ddlChart.value == 6){
      Chart_Direction(1);
    }
    // อัปเดตกราฟ
    //myChart.update();
}
}

// function ChkColor(){
//   if (Check.checked) {
//     if(ddlChart.value == 0){
//       Check.style.backgroundColor = "#f9b234";
//       Check.style.borderColor ="#f9b234";
//       Check.style.boxShadow = "0 0 5px #f9b234";
//     }
//     else if(ddlChart.value == 1){
//       Check.style.backgroundColor = "#f9b234";
//     }
//     else if(ddlChart.value == 2){
//       CCheck.style.backgroundColor = "#f9b234";
//     }
//     else if(ddlChart.value == 3){
//       Check.style.backgroundColor = "#f9b234";
//     }
//     else if(ddlChart.value == 4){
//       Check.style.backgroundColor = "#f9b234";
//     }
//     else if(ddlChart.value == 5){
//       Check.style.backgroundColor = "#f9b234";
//     }
//     else if(ddlChart.value == 6){
//       Check.style.backgroundColor = "#f9b234";
//     } 
//   }else{
//     Check.style.backgroundColor = "";
//     Check.style.borderColor ="none";
//     Check.style.boxShadow = "none";
//   }
// }