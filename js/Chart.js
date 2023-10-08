function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

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
          const PM = data.map(item => parseInt(item.PM));//แปลงค่า PM เป็นตัวเลขและนำมาใส่ในอาเรย์ จาก JSON โดยใช้ obj item เพื่อเข้าถึง Values
           myChart =  new Chart(ctx, {
            type: 'line',
            data: {
              labels: readingTimes,//time
              datasets: [{
                // label: 'PM2.5',
                data: PM,
                backgroundColor: "#f9b234",
                borderColor: "#f9b234",
                borderWidth: 3,
                yAxisID: 'y'
              },
            ]
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
                  font:{
                    size: 17,
                    weight: 'bold',
                    family:'Itim',
                  }
                },
                legend:{
                  display: false,
                }
              },
              scales: {
                x:{
                  ticks:{
                    maxRotation: 0, // ป้องกันการหมุนแท็ก
                    font:{
                      weight: 'bold',
                    }
                  }
                },
                y: {
                  type: 'linear',
                  display: true,
                  position: 'left',
                  ticks:{
                    font:{
                      weight: 'bold',
                    }
                  }
                },
              },
              maintainAspectRatio:false,
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

var first_pm = 1;
function Chart_PM(stop){
  if(stop == 1){
    PM_Interval = setInterval(PM, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_pm == 1){
        first_pm = 0;
        const PM = data.map(item => parseInt(item.PM));
        myChart.options.plugins.title.text = "Chart PM2.5 Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = PM;
        myChart.data.datasets[0].backgroundColor = "#f9b234";
        myChart.data.datasets[0].borderColor = "#f9b234";
        myChart.update();
        sleep(60000);
      }
      }
  });
  }
}

var first_temp = 1;
function Chart_Temp(stop){
  if(stop == 1){
    Temp_Interval = setInterval(Temp, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_temp == 1){
        first_temp = 0;
        const Temperature = data.map(item => parseInt(item.Temperature));
        myChart.options.plugins.title.text = "Chart Temperature Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Temperature;
        myChart.data.datasets[0].backgroundColor = "#3ecd5e";
        myChart.data.datasets[0].borderColor = "#3ecd5e";
        myChart.update();
        sleep(60000);
      }
      }
  });
  }
}

var first_humid = 1;
function Chart_Humid(stop){
  if(stop == 1){
    Humid_Interval = setInterval(Humid, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_humid == 1){
        first_humid = 0;
        const Humidity = data.map(item => parseInt(item.Humidity));
        myChart.options.plugins.title.text = "Chart Humidity Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Humidity;
        myChart.data.datasets[0].backgroundColor = "#e44002";
        myChart.data.datasets[0].borderColor = "#e44002";
        myChart.update();
        sleep(60000);
      }
    }
  });
  }
}

var first_pressure = 1;
function Chart_Pressure(stop){
  if(stop == 1){
    Pressure_Interval = setInterval(Pressure, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_pressure == 1){
        first_pressure = 0;
        const Air_Pressure = data.map(item => parseInt(item.Air_Pressure));
        myChart.options.plugins.title.text = "Chart Air Pressure Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Air_Pressure;
        myChart.data.datasets[0].backgroundColor = "#952aff";
        myChart.data.datasets[0].borderColor = "#952aff";
        myChart.update();
        sleep(60000);
      }
      }
  });
  }
}

var first_speed = 1;
function Chart_Speed(stop){
  if(stop == 1){
    Speed_Interval = setInterval(Speed, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_speed == 1){
        first_speed = 0;
        const Wind_Speed = data.map(item => parseInt(item.Wind_Speed));
        myChart.options.plugins.title.text = "Chart Wind Speed Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Speed;
        myChart.data.datasets[0].backgroundColor = "#cd3e94";
        myChart.data.datasets[0].borderColor = "#cd3e94";
        myChart.update();
        sleep(60000);
      }
      }
  });
  }
}

var first_direction = 1;
function Chart_Direction(stop){
  if(stop == 1){
    Direction_Interval = setInterval(Direction, 10000); 
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
      let Time = new Date();
      let Minute = Time.getMinutes().toString();
      let LastMinute = Minute.charAt(Minute.length - 1);
      if(LastMinute == 0 || LastMinute == 5 || first_direction == 1){
        first_direction = 0;
        const Wind_Direction = data.map(item => parseInt(item.Wind_Direction));
        myChart.options.plugins.title.text = "Chart Wind Direction Value";
        myChart.data.labels = readingTimes;
        myChart.data.datasets[0].data = Wind_Direction;
        myChart.data.datasets[0].backgroundColor = "#4c49ea";
        myChart.data.datasets[0].borderColor = "#4c49ea";
        myChart.update();
        sleep(60000);
      }
      }
  });
  }
}