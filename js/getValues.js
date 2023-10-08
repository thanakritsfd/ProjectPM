function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
 }

 var first_Value = 1;

$(document).ready(function() { 
    setInterval(values, 10000); 
});
   function values() {
    $.ajax({
        url: './api/value_Sensor/api_getvaluesensor.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let Time = new Date();
            let Minute = Time.getMinutes().toString();
            let LastMinute = Minute.charAt(Minute.length - 1);
            if(LastMinute == 0 || LastMinute == 5 || first_Value == 1){
                first_Value = 0;
                $('#pmValue').html(data.PM);
                $('#tempValue').html(data.Temperature);
                $('#humidValue').html(data.Humidity);
                $('#airValue').html(data.Air_Pressure);
                $('#speedValue').html(data.Wind_Speed);
                $('#windValue').html(data.Wind_Direction);
                sleep(60000);
            }
        }
    });
   }
   values();