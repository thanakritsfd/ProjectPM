$(document).ready(function() { 
    setInterval(AQI, 10000); 
});
   function AQI() {
    $.ajax({
        url: './api/value_Sensor/api_getPMavg.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
                let PMavg = parseFloat(data.PMavg);
                let Imin;
                let Imax;
                let Cmin;
                let Cmax;
                let AQI_Value;
                //console.log(PMavg);
                if(PMavg < 16){
                    Imin = 0;
                    Imax = 25;
                    Cmin = 0;
                    Cmax = 15;
                    AQI_Value = Math.round((((Imax - Imin)/(Cmax - Cmin))*(PMavg - Cmin)) + Imin);
                }
                else if(PMavg < 26){
                    Imin = 26;
                    Imax = 50;
                    Cmin = 15.1;
                    Cmax = 25;
                    AQI_Value = Math.round((((Imax - Imin)/(Cmax - Cmin))*(PMavg - Cmin)) + Imin);
                }
                else if(PMavg < 37.6){
                    Imin = 51;
                    Imax = 100;
                    Cmin = 25.1;
                    Cmax = 37.5;
                    AQI_Value = Math.round((((Imax - Imin)/(Cmax - Cmin))*(PMavg - Cmin)) + Imin);
                }
                else if(PMavg < 76){
                    Imin = 101;
                    Imax = 200;
                    Cmin = 37.6;
                    Cmax = 75;
                    AQI_Value = Math.round((((Imax - Imin)/(Cmax - Cmin))*(PMavg - Cmin)) + Imin);
                }
                else {
                    Imin = 200;
                    Imax = 10000000;
                    Cmin = 75.1;
                    Cmax = 10000000;
                    AQI_Value = Math.round((((Imax - Imin)/(Cmax - Cmin))*(PMavg - Cmin)) + Imin);
                }

                let AQI_Show = document.getElementById('AQI');
                AQI_Show.innerHTML = AQI_Value;

                var AQI = document.getElementById('AQI').textContent;
                var AQI_Color = document.getElementById('AQI');
                var AQI_int = parseInt(AQI);
                var card_aqi = document.getElementById('card_aqi');
                var font_air = document.getElementById('font_air');
                var explain = document.getElementById('explain');
                var icon = document.getElementById('icon');

                if(AQI_int < 26){//Very Good
                    card_aqi.style.backgroundColor = "#6CB4EE";
                    font_air.style.color = "#002244";
                    explain.style.color = "#002244";
                    explain.innerHTML = "คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว";
                    AQI_Color.style.color = "#F0F8FF";
                    icon.style.color = "#F0F8FF";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            font_air.style.textShadow  = "2px 2px 0px #F0F8FF";
                            AQI_Color.style.textShadow  = "2px 2px 0px #002244";
                            icon.style.textShadow  = "2px 2px 0px #002244";
                        } else {
                            font_air.style.textShadow  = "4px 4px 0px #F0F8FF";
                            AQI_Color.style.textShadow  = "4px 4px 0px #002244";
                            icon.style.textShadow  = "4px 4px 0px #002244";
                        }
                    }
                }
                else if(AQI_int < 51){//Good
                    card_aqi.style.backgroundColor = "#32de84";
                    font_air.style.color = "#043927";
                    explain.style.color = "#043927";
                    explain.innerHTML = "คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้งและการท่องเที่ยวได้ตามปกติ";
                    AQI_Color.style.color = "#D0F0C0";
                    icon.style.color = "#D0F0C0";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            font_air.style.textShadow  = "2px 2px 0px #D0F0C0";
                            AQI_Color.style.textShadow  = "2px 2px 0px #043927";
                            icon.style.textShadow  = "2px 2px 0px #043927";
                        } else {
                            font_air.style.textShadow  = "4px 4px 0px #D0F0C0";
                            AQI_Color.style.textShadow  = "4px 4px 0px #043927";
                            icon.style.textShadow  = "4px 4px 0px #043927";
                        }
                    }
                }
                else if(AQI_int < 101){//Mid
                    card_aqi.style.backgroundColor = "#FFFF00";
                    font_air.style.color = "#043927";
                    explain.style.color = "#043927";
                    explain.innerHTML = "คุณภาพอากาศปานกลาง สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ หากมีอาการ เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง";
                    AQI_Color.style.color = "#043927";
                    icon.style.color = "#043927";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            font_air.style.textShadow  = "2px 2px 0px #F0E68C";
                            AQI_Color.style.textShadow  = "2px 2px 0px #F0E68C";
                            icon.style.textShadow  = "2px 2px 0px #F0E68C";
                        } else {
                            font_air.style.textShadow  = "4px 4px 0px #F0E68C";
                            AQI_Color.style.textShadow  = "4px 4px 0px #F0E68C";
                            icon.style.textShadow  = "4px 4px 0px #F0E68C";
                        }
                    }
                }
                else if(AQI_int < 201){//Bad
                    card_aqi.style.backgroundColor = "#FF8C00";
                    font_air.style.color = "#FFFFE0";
                    explain.style.color = "#FFFFE0";
                    explain.innerHTML = "คุณภาพอากาศแย่ ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น";
                    AQI_Color.style.color = "#FF0000";
                    icon.style.color = "#FF0000";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            font_air.style.textShadow  = "2px 2px 0px #FF0000";
                            AQI_Color.style.textShadow  = "2px 2px 0px #8B0000";
                            icon.style.textShadow  = "2px 2px 0px #8B0000";
                        } else {
                            font_air.style.textShadow  = "4px 4px 0px #FF0000";
                            AQI_Color.style.textShadow  = "4px 4px 0px #8B0000";
                            icon.style.textShadow  = "4px 4px 0px #8B0000";
                        }
                    }
                }
                else {//Very Bad
                    card_aqi.style.backgroundColor = "#FF004F";
                    font_air.style.color = "#65000B";
                    explain.style.color = "#65000B";
                    explain.innerHTML = "คุณภาพอากาศแย่ ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น";
                    AQI_Color.style.color = "#FFFFE0";
                    icon.style.color = "#FFFFE0";
                    function myFunction(x) {
                        if (x.matches) { // If media query matches
                            font_air.style.textShadow  = "2px 2px 0px #FF0000";
                            AQI_Color.style.textShadow  = "2px 2px 0px #65000B";
                            icon.style.textShadow  = "2px 2px 0px #65000B";
                        } else {
                            font_air.style.textShadow  = "4px 4px 0px #FF0000";
                            AQI_Color.style.textShadow  = "4px 4px 0px #65000B";
                            icon.style.textShadow  = "4px 4px 0px #65000B";
                        }
                    }
                }
                
                var x = window.matchMedia("(max-width: 639px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes        
    }
    });
   }
   AQI();