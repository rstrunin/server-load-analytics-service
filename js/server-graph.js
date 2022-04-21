var request = new XMLHttpRequest();
request.open('GET', 'scripts-to-send-json/json-server-graph.php', true);

request.onload = function() {
    if (this.status >= 200 && this.status < 400) {
        // Если файл открыт
        let data = JSON.parse(this.response);
        let series = [];

        for (let tuple in data) {

            let graphData = [];

            for (let date in data[tuple]) {
                graphData.push([
                    data[tuple][date]['stat_date'] * 1000,
                    data[tuple][date]['meetings'] * 1,
                ]);
            }

            console.log(graphData);

            series.push({
                name: tuple,
                data: graphData,
                dashStyle: 'shortdot',
            });
        }

        Highcharts.stockChart('container3', {
            title: {
                text: 'График нагрузки по серверам за период',
            },
            xAxis: {
                type: 'datetime',
                labels: {
                    formatter: function() {
                        return Highcharts.dateFormat('%e %b %y', this.value);
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Команты (meetings)'
                }
            },
            rangeSelector: {
                enabled: false
            },
            series: series
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