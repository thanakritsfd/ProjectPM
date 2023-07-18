const ctx = document.getElementById('myChart');
new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],
      datasets: [{
        label: 'Temperature',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: "#f9b234",
        borderColor: "#f9b234",
        borderWidth: 1,
        yAxisID: 'y1'
      },
      {
        label: 'Humidity',
        data: [22, 9, 7, 5, 6, 13],
        backgroundColor: "#3ecd5e",
        borderColor: "#3ecd5e",
        borderWidth: 1,
        yAxisID: 'y2'
      },
      {
        label: 'Air Pressure',
        data: [47, 56, 10, 45, 34, 30],
        backgroundColor: "#e44002",
        borderColor: "#e44002",
        borderWidth: 1,
        yAxisID: 'y3'
    },
    {
        label: 'Wind Speed',
        data: [20, 19, 23, 25, 22, 33],
        backgroundColor: "#952aff",
        borderColor: "#952aff",
        borderWidth: 1,
        yAxisID: 'y4'
      },
      {
        label: 'Wind Direction',
        data: [33, 22, 35, 3, 23, 37],
        backgroundColor: "#cd3e94",
        borderColor: "#cd3e94",
        borderWidth: 1,
        yAxisID: 'y5'
      },
      {
        label: 'Traffic',
        data: [52, 15, 7, 4, 24, 8],
        backgroundColor: "#4c49ea",
        borderColor: "#4c49ea", 
        borderWidth: 1,
        yAxisID: 'y6'
      }
    ]
    },
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      stacked: false,
      plugins: {
        title: {
          display: true,
          text: 'Chart Multi Value'
        }
      },
      scales: {
        y1: {
          type: 'linear',
          display: true,
          position: 'left',
        },
        y2: {
          type: 'linear',
          display: true,
          position: 'left',
        },
        y3: {
          type: 'linear',
          display: true,
          position: 'left',
        },
        y4: {
          type: 'linear',
          display: true,
          position: 'right',
        },
        y5: {
          type: 'linear',
          display: true,
          position: 'right',
        },
        y6: {
          type: 'linear',
          display: true,
          position: 'right',
        },
      }
    },
  });
