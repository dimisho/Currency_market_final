// window.onload = async function data() {
//     const url = 'https://export.finam.ru/export9.out?market=5&em=66860&code=EURRUB&apply=0&df=18&mf=3&yf=2022&from=17.04.2022&dt=24&mt=3&yt=2022&to=24.04.2022&p=3&f=EURRUB_220418_220424&e=.txt&cn=EURRUB&dtf=1&tmf=1&MSOR=1&mstime=on&mstimever=1&sep=3&sep2=1&datf=1&at=1'
//     // const myHeaders = new Headers();
//     // myHeaders.set('Access-Control-Allow-Origin', '*');
//         fetch(url)
//             .then(res => res.text())
//             .then(text => dataparse(text))
//
//
//
//
//
// }


    function dataparse (data) {
        // console.log(data.data)
        console.log(Papa.parse(data))

    }


var a = document.getElementById('btn');
var b = document.getElementById('btn1');
var t_n = document.getElementById('list')
t_n.addEventListener('change',changeOption )
function changeOption(){
    getdata(t_n.value);
    startStream(t_n);

    msftDataTable.remove("1950-12-28", "2050-04-15")
}

function dataparse (data) {
    // console.log(data.data)
    ndata = Papa.parse(data)
    // console.log(ndata.data.length)
    lst =[]
    for(var i = 1; i < ndata.data.length-1; i++) {
        // console.log(ndata.data[i][2][2])
        dat = `${ndata.data[i][2][0]}${ndata.data[i][2][1]}${ndata.data[i][2][2]}${ndata.data[i][2][3]}-${ndata.data[i][2][4]}${ndata.data[i][2][5]}-${ndata.data[i][2][6]}${ndata.data[i][2][7]}T${ndata.data[i][3][0]}${ndata.data[i][3][1]}:${ndata.data[i][3][2]}${ndata.data[i][3][3]}:${ndata.data[i][3][4]}${ndata.data[i][3][5]}`;
        console.log(dat)
        lst.push(
            [
                dat,
                ndata.data[i][4],
                ndata.data[i][5],
                ndata.data[i][6],
                ndata.data[i][7],
            ])
    }
    console.log(lst)
    UpdateData( lst)



}
//
// function getName(value){
//   switch(value) {
//       case '901':// if (x === 'value1')
//           name = 'USD'
//           break
//       case '66860':// if (x === 'value1')
//           name = 'EUR'
//           break
//       case '498844':// if (x === 'value1')
//           name = 'UAH'
//           break
//       case '456495':// if (x === 'value1')
//           name = 'BYN'
//           break
//       case '399725':// if (x === 'value1')
//           name = 'GBP'
//           break
//   }
//   console.log(name)
//   return name
// }
function updParseData(data, id){
    const date = new Date();
    switch(t_n.value) {
        case '901':// if (x === 'value1')
            name = 'USD'
            break
        case '66860':// if (x === 'value1')
            name = 'EUR'
            break
        case '498844':// if (x === 'value1')
            name = 'UAH'
            break
        case '456495':// if (x === 'value1')
            name = 'BYN'
            break
        case '399725':// if (x === 'value1')
            name = 'GBP'
            break
    }
    $.ajax({
        type: 'GET',              // Задаем метод передачи
        url: 'view_text.php?ticker=' + name, // URL для передачи параметра
        success: function(data) {
            //alert(data); // Выводим результат на экран
            document.getElementById('myTicker').value = data;
            document.getElementById('myTicker2').value = data;
        }
    });
    console.log(name);
    date.toISOString()
    lst = [];
    $.ajax({
        type: 'GET',              // Задаем метод передачи
        url: 'view_text.php?price=' + data[name]['Value'], // URL для передачи параметра
        success: function(data) {
            //alert(data); // Выводим результат на экран
            var p = document.getElementById("p");
            var span = document.getElementById("span");

            p.innerHTML = data + span.outerHTML;
            document.getElementById('myPrice').value = data;
            document.getElementById('myPrice2').value = data;
        }
    });
    console.log(data[name]['Value'])
    lst.push([
        date,
        data[name]['Value'],
        data[name]['Value'],
        data[name]['Value'],
        data[name]['Value'],

    ])

    UpdateData( lst)

}

function gethistorydata(id){
    fetch(`https://export.finam.ru/export9.out?market=5&em=${id}&code=RUB&apply=0&df=18&mf=3&yf=2022&from=18.04.2022&dt=24&mt=3&yt=2022&to=24.04.2022&p=3&f=$RUB_220418_220424&e=.txt&cn=$RUB&dtf=1&tmf=1&MSOR=1&mstime=on&mstimever=1&sep=3&sep2=1&datf=1&at=1`)
        .then(res => res.text())
        .then(data =>{
            dataparse(data, id)
        })

}


function getdata(id){
    fetch(`https://www.cbr-xml-daily.ru/daily_json.js`)
        .then(res => res.json())
        .then(data =>{
            updParseData(data.Valute, id)
        })

}



b.onclick = ( () =>{
    msftDataTable.remove("1950-12-28", "2050-04-15")
    data = gethistorydata(t_n.value)
})

a.onclick = ( () =>{

    a.style.backgroundColor = 'red'
    startStream(t_n)

})

window.onload = function renderchart(data, id){
    // var t_n = document.getElementById('tiker_name')
    $('#asd').on('select2:select', function (e) {
        var data = e.params.data;
        t_n.append(data.id)
        msftDataTable.remove("1950-12-28", "2050-04-15")

    });

    msftDataTable = anychart.data.table();
    // msftDataTable.addData(data);

    var chart = anychart.stock();
    firstPlot = chart.plot(0);
    firstPlot
        .line()
        .data(msftDataTable.mapAs({ value: 4 }))
        .name('RUB');


    chart.scroller().line(msftDataTable.mapAs({ value: 4 }));

    // chart.selectRange('2005-01-03', '2005-11-20');
    var rangeSelector = anychart.ui.rangeSelector();
    var rangePicker = anychart.ui.rangePicker();

    // set container id for the chart
    chart.container('container');
    // initiate chart drawing
    chart.draw();
    rangePicker.render(chart);
    rangeSelector.render(chart);



}

function UpdateData( data){
    msftDataTable.addData(data)

}


function startStream(id) {


    var streamButton = document.getElementById("btn");


    // set interval of data stream
    var myVar = setInterval(

        // data streaming itself
        function() {


            getdata(id)
        }, 5000            // interval
    );

    streamButton.onclick = function() {

        // clears interval which stops streaming
        clearInterval(myVar);
        streamButton.onclick = function () {
            startStream();
        };
    };
}
