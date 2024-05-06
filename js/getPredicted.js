$(document).ready(function() { 
    setInterval(predicted, 10000); 
});
   function predicted() {
    $.ajax({
        url: './api/predicted/api_getPredicted.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data)
            switch(data.prediction_1_hour) {
                case "คุณภาพแย่มาก":
                    $('#one').html(data.prediction_1_hour + "<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/5.png');
                    break;
                case "คุณภาพแย่":
                    $('#one').html(data.prediction_1_hour + "<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/4.png');
                    break;
                case "คุณภาพปานกลาง":
                    $('#one').html(data.prediction_1_hour + "<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/3.png');
                    break;
                case "คุณภาพดี":
                    $('#one').html(data.prediction_1_hour + "<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/2.png');
                    break;
                default:
                    $('#one').html(data.prediction_1_hour + "<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/1.png');
            }

            switch(data.prediction_3_hours) {
                case "คุณภาพแย่มาก":
                    $('#three').html(data.prediction_3_hours + "<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/5.png');
                    break;
                case "คุณภาพแย่":
                    $('#three').html(data.prediction_3_hours + "<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/4.png');
                    break;
                case "คุณภาพปานกลาง":
                    $('#three').html(data.prediction_3_hours + "<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/3.png');
                    break;
                case "คุณภาพดี":
                    $('#three').html(data.prediction_3_hours + "<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/2.png');
                    break;
                default:
                    $('#three').html(data.prediction_3_hours + "<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/1.png');
            }

            switch(data.prediction_6_hours) {
                case "คุณภาพแย่มาก":
                    $('#six').html(data.prediction_6_hours + "<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/5.png');
                    break;
                case "คุณภาพแย่":
                    $('#six').html(data.prediction_6_hours + "<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/4.png');
                    break;
                case "คุณภาพปานกลาง":
                    $('#six').html(data.prediction_6_hours + "<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/3.png');
                    break;
                case "คุณภาพดี":
                    $('#six').html(data.prediction_6_hours + "<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/2.png');
                    break;
                default:
                    $('#six').html(data.prediction_6_hours + "<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/1.png');
            }

            switch(data.prediction_12_hours) {
                case "คุณภาพแย่มาก":
                    $('#twelve').html(data.prediction_12_hours + "<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/5.png');
                    break;
                case "คุณภาพแย่":
                    $('#twelve').html(data.prediction_12_hours + "<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/4.png');
                    break;
                case "คุณภาพปานกลาง":
                    $('#twelve').html(data.prediction_12_hours + "<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/3.png');
                    break;
                case "คุณภาพดี":
                    $('#twelve').html(data.prediction_12_hours + "<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/2.png');
                    break;
                default:
                    $('#twelve').html(data.prediction_12_hours + "<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/1.png');
            }
            
            switch(data.prediction_24_hours) {
                case "คุณภาพแย่มาก":
                    $('#day').html(data.prediction_24_hours + "<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/5.png');
                    break;
                case "คุณภาพแย่":
                    $('#day').html(data.prediction_24_hours + "<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/4.png');
                    break;
                case "คุณภาพปานกลาง":
                    $('#day').html(data.prediction_24_hours + "<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/3.png');
                    break;
                case "คุณภาพดี":
                    $('#day').html(data.prediction_24_hours + "<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/2.png');
                    break;
                default:
                    $('#day').html(data.prediction_24_hours + "<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/1.png');
            }
        }
    });
   }
   predicted();