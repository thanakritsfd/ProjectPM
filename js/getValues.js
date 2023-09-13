$(document).ready(function() { 
    setInterval(values, 1000); 
});
   function values() {
    $.ajax({
        url: './api/value_Sensor/api_getvaluesensor.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#pmValue').html(data.PM);
            $('#tempValue').html(data.Temperature);
            $('#humidValue').html(data.Humidity);
            $('#airValue').html(data.Air_Pressure);
            $('#speedValue').html(data.Wind_Speed);
            $('#windValue').html(data.Wind_Direction);
        }
    });
   }
   values();