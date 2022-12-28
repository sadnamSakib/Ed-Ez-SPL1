if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

var myChartCircle = new Chart('chartProgress', {
  type: 'doughnut',
  data: {
    datasets: [{
      label: 'Total percentage',
      percent: ((50 * 100) / 75),
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
        textX = Math.round((width - ctx.measureText(text).width) / 2.1),
          textY = height / 2;
        ctx.fillText(text + "%", textX, textY);
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



class TxtType {
  constructor(el, toRotate, period) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 500;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
  }
  tick() {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
      this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
      this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

    var that = this;
    var delta = 200 - Math.random() * 100;

    if (this.isDeleting) {
      delta /= 2;
    }

    if (!this.isDeleting && this.txt === fullTxt) {
      delta = this.period;
      this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
      this.isDeleting = false;
      this.loopNum++;
      delta = 100;
    }

    setTimeout(function () {
      that.tick();
    }, delta);
  }
}


window.onload = function () {
  var elements = document.getElementsByClassName('typewrite');
  for (var i = 0; i < elements.length; i++) {
    var toRotate = elements[i].getAttribute('data-type');
    var period = elements[i].getAttribute('data-period');
    if (toRotate) {
      new TxtType(elements[i], JSON.parse(toRotate), period);
    }
  }
  var css = document.createElement("style");
  css.type = "text/css";
  css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
  document.body.appendChild(css);
};


function myFunctionsmall() {
  document.getElementById("myDropdownsmall").classList.toggle("show");
}
window.onclick = function(event) {
  if (!event.target.matches('.dropbtnsmall')) {
    var dropdowns = document.getElementsByClassName("dropdown-contentsmall");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
};


function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
};

