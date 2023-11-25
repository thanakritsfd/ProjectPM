var Close_PM = document.getElementById('Close_PM');
var Close_Temp = document.getElementById('Close_Temp');
var Close_Humid = document.getElementById('Close_Humid');
var Close_Speed = document.getElementById('Close_Speed');
var Close_Pressure = document.getElementById('Close_Pressure');
var Close_Direction = document.getElementById('Close_Direction'); 

const ctx = document.getElementById('myChart');
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
            const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
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
                text: 'Chart PM2.5 Value',
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


function Chart_PM(stop){
  if(stop == 1){
    clearInterval(PM_Interval);
    PM_Interval = setInterval(PM, 1000); 
  PM();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const PM = data.map(item => parseInt(item.PM));
        myChart.options.plugins.title.text = "Chart PM2.5 Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = PM;
        myChart.data.datasets[0].backgroundColor = "#f9b234";
        myChart.data.datasets[0].borderColor = "#f9b234";
        myChart.update();           
      }
  });
  }
}

function Chart_Temp(stop){
  if(stop == 1){
    clearInterval(Temp_Interval);
    Temp_Interval = setInterval(Temp, 1000); 
  Temp();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const Temperature = data.map(item => parseInt(item.Temperature));
        myChart.options.plugins.title.text = "Chart Temperature Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Temperature;
        myChart.data.datasets[0].backgroundColor = "#3ecd5e";
        myChart.data.datasets[0].borderColor = "#3ecd5e";
        myChart.update();
      }
  });
  }
}

function Chart_Humid(stop){
  if(stop == 1){
    clearInterval(Humid_Interval);
    Humid_Interval = setInterval(Humid, 1000); 
    Humid();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const Humidity = data.map(item => parseInt(item.Humidity));
        myChart.options.plugins.title.text = "Chart Humidity Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Humidity;
        myChart.data.datasets[0].backgroundColor = "#e44002";
        myChart.data.datasets[0].borderColor = "#e44002";
        myChart.update();
    }
  });
  }
}

function Chart_Pressure(stop){
  if(stop == 1){
    clearInterval(Pressure_Interval);
    Pressure_Interval = setInterval(Pressure, 1000); 
    Pressure();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const Air_Pressure = data.map(item => parseInt(item.Air_Pressure));
        myChart.options.plugins.title.text = "Chart Air Pressure Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Air_Pressure;
        myChart.data.datasets[0].backgroundColor = "#952aff";
        myChart.data.datasets[0].borderColor = "#952aff";
        myChart.update();
      }
  });
  }
}

function Chart_Speed(stop){
  if(stop == 1){
    clearInterval(Speed_Interval);
    Speed_Interval = setInterval(Speed, 1000); 
    Speed();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const Wind_Speed = data.map(item => parseInt(item.Wind_Speed));
        myChart.options.plugins.title.text = "Chart Wind Speed Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Speed;
        myChart.data.datasets[0].backgroundColor = "#cd3e94";
        myChart.data.datasets[0].borderColor = "#cd3e94";
        myChart.update();        
      }
  });
  }
}

function Chart_Direction(stop){
  if(stop == 1){
    clearInterval(Direction_Interval);
    Direction_Interval = setInterval(Direction, 1000); 
    Direction();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const Wind_Direction = data.map(item => parseInt(item.Wind_Direction));
        myChart.options.plugins.title.text = "Chart Wind Direction Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Direction;
        myChart.data.datasets[0].backgroundColor = "#4c49ea";
        myChart.data.datasets[0].borderColor = "#4c49ea";
        myChart.update();
      }
  });
  }
}

function Chart_AQI(stop){
  if(stop == 1){
    clearInterval(AQI_Interval);
    AQI_Interval = setInterval(AQI, 1000); 
    AQI();
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
          const dateTH2 = dateTH.replaceAll('-', '/');// dd/MM/yyy
          const timeParts = dateTimeParts[1].split(':').slice(0, 2).join(':'); // เอาเฉพาะชั่วโมงและนาที slice(0, 2)เริ่มที่ 0 = index[0] |  2 = เริ่มจากค่าสุดท้ายของอาเรย์นับถถอยหลังมาเริ่มนับที่ 1
          return [timeParts, dateTH2];//แบ่งแบบนี้เพื่อขึ้นบรรทัดใหม่
      });
        const AQI = data.map(item => parseInt(item.AQI));
        myChart.options.plugins.title.text = "Chart AQI Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = AQI;
        myChart.data.datasets[0].backgroundColor = "#000000";
        myChart.data.datasets[0].borderColor = "#000000";
        myChart.update();
      }
  });
  }
}