async function moexTickerLast(ticker) {
  const json = await fetch('https://iss.moex.com/iss/engines/stock/markets/shares/securities/' + ticker + '.json').then(function(res) { return res.json()});
  return json.marketdata.data.filter(function(d) { return ['TQBR', 'TQTF'].indexOf(d[1]) !== -1; })[0][12];
}
var ticker = 'SBER';

window.onload = function () {
  var dataPoints = [], currentDate = new Date(), rangeChangedTriggered = false;
   var stockChart = new CanvasJS.StockChart("chartContainer",{
    theme: "dark1", //"light2", "dark1", "dark2"
    title:{
      text:"Dynamic StockChart"
    },
    rangeChanged: function(e) {
        rangeChangedTriggered = true;
    },
    charts: [{
      axisX: {
        crosshair: {
          enabled: true,
          valueFormatString: "MMM DD, YYYY HH:mm:ss"
        }
      },
      axisY: {
        title: "Pageviews Per Second"
      },
      toolTip: {
        shared: true
      },
      data: [{
        type: "line",
        name: "Pageviews",
        xValueFormatString: "MMM DD, YYYY HH:mm:ss",
        xValueType: "dateTime",
        dataPoints : dataPoints
      }]
    }],
    navigator: {
      slider: {
        minimum: new Date(currentDate.getTime() - (90 * 1000))
      },
      axisX: {
        labelFontColor: "white"
      }
    },
    rangeSelector: {
      enabled: false
    }
  });
  moexTickerLast(ticker).then(

  	result => {
  		 var dataCount = 700, ystart = result, interval = 5000, xstart = (currentDate.getTime() - (700 * 1000));
  		updateChart(xstart, ystart, dataCount, interval);

  	});
  function updateChart(xstart, ystart, length, interval) {
    var price = ystart;
    $.ajax({
        type: 'GET',              // Задаем метод передачи
        url: 'view_text.php?price=' + price, // URL для передачи параметра
        success: function(data) {
            //alert(data); // Выводим результат на экран
            var p = document.getElementById("p");
            var span = document.getElementById("span");

            p.innerHTML = data + span.outerHTML;
            document.getElementById('myPrice').value = data;
            document.getElementById('myPrice2').value = data;
        }
    });
    $.ajax({
        type: 'GET',              // Задаем метод передачи
        url: 'view_text.php?ticker=' + ticker, // URL для передачи параметра
        success: function(data) {
            //alert(data); // Выводим результат на экран
            document.getElementById('myTicker').value = data;
            document.getElementById('myTicker2').value = data;
        }
    });

    var xVal = xstart, yVal = ystart;
    xVal += interval;
    dataPoints.push({x: xVal,y: yVal});
    if(!rangeChangedTriggered) {
        stockChart.options.navigator.slider.minimum = new Date(xVal - (90 * 1000)) ;
    }
    xstart = xVal;
    dataCount = 1;
    ystart = yVal;
    stockChart.render();
    setTimeout(function() { moexTickerLast(ticker).then(result => {updateChart((xstart), result, dataCount, interval)}); }, 5000);
  }
}
// let timerId = setInterval(() => moexTickerLast('SBER').then(result => console.log(result)), 2000);
