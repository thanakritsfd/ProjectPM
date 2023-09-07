const ctx = document.getElementById('myChart');

  const myChart =  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],
      datasets: [{
        // label: 'PM2.5',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: "#f9b234",
        borderColor: "#f9b234",
        borderWidth: 3,
        yAxisID: 'y1'
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
          text: 'Chart PM2.5 Value'
        },
        legend:{
          display: false,
        }
      },
      scales: {
        y1: {
          type: 'linear',
          display: true,
          position: 'left',
        },
      }
    },
  });


function Chart_PM(){
  myChart.options.plugins.title.text = "Chart PM2.5 Value";
  myChart.data.datasets[0].data = [12, 19, 3, 5, 2, 3];
  myChart.data.datasets[0].backgroundColor = "#f9b234";
  myChart.data.datasets[0].borderColor = "#f9b234";
  myChart.update();
}

function Chart_Temp(){
  myChart.options.plugins.title.text = "Chart Temperature Value";
  myChart.data.datasets[0].data = [52, 15, 7, 4, 24, 8];
  myChart.data.datasets[0].backgroundColor = "#3ecd5e";
  myChart.data.datasets[0].borderColor = "#3ecd5e";
  myChart.update();
}

function Chart_Humid(){
  myChart.options.plugins.title.text = "Chart Humidity Value";
  myChart.data.datasets[0].data = [22, 9, 7, 5, 6, 13];
  myChart.data.datasets[0].backgroundColor = "#e44002";
  myChart.data.datasets[0].borderColor = "#e44002";
  myChart.update();
}

function Chart_Pressure(){
  myChart.options.plugins.title.text = "Chart Air Pressure Value";
  myChart.data.datasets[0].data = [47, 56, 10, 45, 34, 30];
  myChart.data.datasets[0].backgroundColor = "#952aff";
  myChart.data.datasets[0].borderColor = "#952aff";
  myChart.update();
}

function Chart_Speed(){
  myChart.options.plugins.title.text = "Chart Wind Speed Value";
  myChart.data.datasets[0].data = [20, 19, 23, 25, 22, 33];
  myChart.data.datasets[0].backgroundColor = "#cd3e94";
  myChart.data.datasets[0].borderColor = "#cd3e94";
  myChart.update();
}

function Chart_Direction(){
  myChart.options.plugins.title.text = "Chart Wind Direction Value";
  myChart.data.datasets[0].data = [33, 22, 35, 3, 23, 37];
  myChart.data.datasets[0].backgroundColor = "#4c49ea";
  myChart.data.datasets[0].borderColor = "#4c49ea";
  myChart.update();
}