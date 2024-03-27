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
                case "1":
                    $('#one').html("คุณภาพแย่มาก<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/5.png');
                    break;
                case "2":
                    $('#one').html("คุณภาพแย่<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/4.png');
                    break;
                case "3":
                    $('#one').html("คุณภาพปานกลาง<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/3.png');
                    break;
                case "4":
                    $('#one').html("คุณภาพดี<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/2.png');
                    break;
                default:
                    $('#one').html("คุณภาพดีมาก<br>"+ data.datatime1 + " น.");
                    $('#img_1').attr('src', './images/1.png');
            }

            switch(data.prediction_3_hours) {
                case "1":
                    $('#three').html("คุณภาพแย่มาก<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/5.png');
                    break;
                case "2":
                    $('#three').html("คุณภาพแย่<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/4.png');
                    break;
                case "3":
                    $('#three').html("คุณภาพปานกลาง<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/3.png');
                    break;
                case "4":
                    $('#three').html("คุณภาพดี<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/2.png');
                    break;
                default:
                    $('#three').html("คุณภาพดีมาก<br>"+ data.datatime3 + " น.");
                    $('#img_3').attr('src', './images/1.png');
            }

            switch(data.prediction_6_hours) {
                case "1":
                    $('#six').html("คุณภาพแย่มาก<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/5.png');
                    break;
                case "2":
                    $('#six').html("คุณภาพแย่<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/4.png');
                    break;
                case "3":
                    $('#six').html("คุณภาพปานกลาง<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/3.png');
                    break;
                case "4":
                    $('#six').html("คุณภาพดี<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/2.png');
                    break;
                default:
                    $('#six').html("คุณภาพดีมาก<br>"+ data.datatime6 + " น.");
                    $('#img_6').attr('src', './images/1.png');
            }

            switch(data.prediction_12_hours) {
                case "1":
                    $('#twelve').html("คุณภาพแย่มาก<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/5.png');
                    break;
                case "2":
                    $('#twelve').html("คุณภาพแย่<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/4.png');
                    break;
                case "3":
                    $('#twelve').html("คุณภาพปานกลาง<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/3.png');
                    break;
                case "4":
                    $('#twelve').html("คุณภาพดี<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/2.png');
                    break;
                default:
                    $('#twelve').html("คุณภาพดีมาก<br>"+ data.datatime12 + " น.");
                    $('#img_12').attr('src', './images/1.png');
            }
            
            switch(data.prediction_24_hours) {
                case "1":
                    $('#day').html("คุณภาพแย่มาก<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/5.png');
                    break;
                case "2":
                    $('#day').html("คุณภาพแย่<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/4.png');
                    break;
                case "3":
                    $('#day').html("คุณภาพปานกลาง<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/3.png');
                    break;
                case "4":
                    $('#day').html("คุณภาพดี<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/2.png');
                    break;
                default:
                    $('#day').html("คุณภาพดีมาก<br>"+ data.datatime24 + " น.");
                    $('#img_24').attr('src', './images/1.png');
            }
        }
    });
   }
   predicted();