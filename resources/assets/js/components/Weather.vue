<template>
    <div class="panel" :style="style" id="current-weather">
        <div class="title">
            <i class="fa fa-fw fa-cloud"></i> Weather
        </div>

        <div class="content">
            <h3 class="description">{{ description }}</h3>

            <div id="weather-data">
                <div class="icon">
                    <i :class="icon"></i>
                </div>

                <div class="temperature">{{ temperature }} &#8451;</div>
            </div>
        </div>
    </div>
</template>

<script>
    let data = {
        temperature: 30,
        icon: '',
        description: ''
    };

    function getCurrentWeatherData() {
        axios.get('/api/weather/current')
            .then(function (response) {
                let responseData = response.data;

                if (responseData.message !== "") {
                    console.log(payload.message);
                } else {
                    let payload = responseData.payload;
                    let weather = (typeof payload.weather[0] !== "undefined" ? payload.weather[0] : false);

                    if (weather) {
                        data.temperature = (payload.main.temp - 273.15).toFixed(1);
                        data.description = weather.description;
                        data.icon = 'wi wi-owm-' + weather.id;
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    setInterval(getCurrentWeatherData, 60000);
    getCurrentWeatherData();

    export default {
        props: ['area'],
        computed: {
            style () {
                return 'grid-area: ' + this.area;
            }
        },
        data: function () {
            return data
        },
        mounted() {
            console.log('Weather component mounted.')
        }
    }
</script>