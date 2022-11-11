  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
  var myChartCircle = new Chart('chartProgress', {
    type: 'doughnut',
    data: {
      datasets: [{
        label: 'Total percentage',
        percent: (50 * 100) / 75,
        backgroundColor: ['#2f6d8b']
      }]
    },
    plugins: [{
        beforeInit: (chart) => {
          const dataset = chart.data.datasets[0];
          chart.data.labels = [dataset.label];
          dataset.data = [dataset.percent, 100 - dataset.percent];
        }
      },
      {
        beforeDraw: (chart) => {
          var width = chart.chart.width,
            height = chart.chart.height,
            ctx = chart.chart.ctx;
          ctx.restore();
          var fontSize = (height / 50).toFixed(2);
          ctx.font = fontSize + "em sans-serif";
          ctx.fillStyle = "#9b9b9b";
          ctx.textBaseline = "middle";

          var text = "A+";
          if (chart.data.datasets[0].percent >= 80) {
            text = "A+";
          } else if (chart.data.datasets[0].percent >= 75) {
            text = "A";
          } else if (chart.data.datasets[0].percent >= 70) {
            text = "A-";
          } else if (chart.data.datasets[0].percent >= 65) {
            text = "B+";
          } else if (chart.data.datasets[0].percent >= 60) {
            text = "B";
          } else if (chart.data.datasets[0].percent >= 55) {
            text = "B-";
          } else if (chart.data.datasets[0].percent >= 50) {
            text = "C+";
          } else if (chart.data.datasets[0].percent >= 45) {
            text = "C";
          } else if (chart.data.datasets[0].percent >= 40) {
            text = "D";
          } else {
            text = "F";
          }

          textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;

          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
    ],
    options: {
      maintainAspectRatio: false,
      cutoutPercentage: 80,
      rotation: Math.PI / 2,
      legend: {
        display: false,
      },
      tooltips: {
        filter: tooltipItem => tooltipItem.index == 0
      }
    }
  });
