<template>
    <div id="forecast-weather" class="text-center">
        <div class="column-wrapper small horizontal">
            <div class="column column-12">
                <div class="text-center">
                    7-daagse voorspelling
                </div>

                <div class="chart-wrapper">
                    <canvas id="forecast-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let forecastChart;

    function initChart() {
        forecastChart = new Chart(document.getElementById("forecast-chart"), {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Min',
                        data: [],
                        borderColor: '#113940',
                        backgroundColor: 'transparent',
                        borderWidth: 2
                    },
                    {
                        label: 'Max',
                        data: [],
                        borderColor: '#FF6918',
                        backgroundColor: 'transparent',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    }

    function getForecastWeatherData() {
        axios.get('/api/weather/forecast')
            .then(function (response) {
                let responseData = response.data;

                if (responseData.message !== "") {
                    console.log(payload.message);
                } else {
                    let payload = responseData.payload;
                    let forecastItems = payload.list.slice(0, 7);
                    let chartDataMax = [];
                    let chartDataMin = [];
                    let chartLabels = [];

                    for (let i = 0; i < forecastItems.length; i++) {
                        let item = forecastItems[i];
                        let label = moment(item.dt * 1000).locale('nl').calendar(null, {
                            sameDay: '[Vandaag]',
                            nextDay: '[Morgen]',
                            nextWeek: 'dddd'
                        });

                        label = window.capitalize(label);

                        chartLabels.push(label);
                        chartDataMax.push((item.temp.max - 273.15).toFixed(1));
                        chartDataMin.push((item.temp.min - 273.15).toFixed(1));
                    }

                    forecastChart.data.labels = chartLabels;
                    forecastChart.data.datasets[0].data = chartDataMin;
                    forecastChart.data.datasets[1].data = chartDataMax;

                    forecastChart.update();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    setInterval(getForecastWeatherData, (60000 * 60)); // Refresh every hour
    getForecastWeatherData();

    export default {
        data: function () {
            return {}
        },
        mounted() {
            initChart();

            console.log('Weather/Forecast component mounted.')
        }
    }
</script>