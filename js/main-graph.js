var request = new XMLHttpRequest();
request.open('GET', 'scripts-to-send-json/json-main-graph.php', true);

request.onload = function() {
    if (this.status >= 200 && this.status < 400) {
        // Если файл открыт
        let data = JSON.parse(this.response);
        let meetings = [], 
            participants = [];

        for (let tuple in data) {
            meetings.push([
                data[tuple]['stat_date'] * 1000,
                data[tuple]['meetings'] * 1,
            ]);

            participants.push([
                data[tuple]['stat_date'] * 1000,
                data[tuple]['participants'] * 1,
            ]);
        }

        Highcharts.stockChart('container', {

            rangeSelector: {
                selected: 1,
                buttons: [{
                    type: 'minute',
                    count: 10,
                    text: '10м'
                }, {
                    type: 'hour',
                    count: 1,
                    text: '1час'
                }, {
                    type: 'hour',
                    count: 6,
                    text: '6час'
                }, {
                    type: 'day',
                    count: 1,
                    text: '1дн'
                }, {
                    type: 'week',
                    count: 1,
                    text: 'нед'
                }, {
                    type: 'month',
                    count: 1,
                    text: 'мес'
                }]
            },

            title: {
                text: 'График нагрузки серверов за месяц' 
            },

            yAxis: [{
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'Собрания (meetings)'
                },
                height: '50%',
                lineWidth: 1,
                resize: {
                    enabled: true
                }
            }, {
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'Участники (participants)'
                },
                top: '52%',
                height: '50%',
                offset: 0,
                lineWidth: 1
            }],

            tooltip: {
                split: true
            },

            xAxis: {
                type: "datetime",
                labels: {
                    formatter: function() {
                        return Highcharts.dateFormat('%e %b %y', this.value);
                    }
                }
            },

            series: [{
                type: 'line',
                name: 'Количество собраний',
                data: meetings, 
                yAxis: 0
            }, {
                type: 'line',
                name: 'Количество участников',
                data: participants,
                yAxis: 1
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