var request = new XMLHttpRequest();
request.open('GET', 'scripts-to-send-json/json-server-bar.php', true);

request.onload = function() {
    if (this.status >= 200 && this.status < 400) {
        // Если файл открыт
        let data = JSON.parse(this.response);
        let server = [],
            avgMeetings = [],
            maxMeetings = [];
        
        for (let tuple in data) {
            server.push([
                data[tuple]['server_name'],
            ]);

            avgMeetings.push([
                data[tuple]['avg_meetings'] * 1,
            ]);

            maxMeetings.push([
                data[tuple]['max_meetings'] * 1,
            ]);
        }
    
        Highcharts.chart('container2', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Среднее и максимальное количество комнат по серверам за период'
            },
            xAxis: {
                categories: server,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Количество комнат на сервере',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' комнат'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Средняя',
                data: avgMeetings
            }, {
                name: 'Максимальная',
                data: maxMeetings
            }]
        });
    } 
    else {
        // Если возникла ошибка
        console.log("Возникла ошибка при загрузке JSON-файла: " + this.status);
    }
};

request.onerror = function() {
  console.log("Возникла ошибка в ходе транзакции");
};

request.send();