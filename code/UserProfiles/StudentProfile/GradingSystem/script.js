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
          var fontSize = (height / 90).toFixed(2);
          ctx.font = fontSize + "em sans-serif";
          ctx.fillStyle = "#9b9b9b";
          ctx.textBaseline = "middle";

          

          var text = chart.data.datasets[0].percent.toFixed(2);
          textX = Math.round((width - ctx.measureText(text).width) / 2.2),
            textY = height / 2;
          ctx.fillText(text+"%", textX, textY);
          ctx.save();
        }
      }
    ],
    options: {
      maintainAspectRatio: false,
      aspectRatio: 1,
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

$(".progress-bar.progressBar1").animate({
    width: "70%",
}, 250);

