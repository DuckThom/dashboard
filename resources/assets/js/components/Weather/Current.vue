<template>
    <div id="current-weather" class="text-center">
        <div class="column-wrapper small horizontal">
            <div class="column column-12">
                <h3 class="location">{{ location }}</h3>
            </div>
        </div>

        <div class="column-wrapper small horizontal">
            <div class="column column-4">
                <div class="icon">
                    <i :class="icon"></i>
                </div>
            </div>
            <div class="column column-8" id="temperature-column">
                <div class="temperature">{{ temperature }} &#8451;</div>
            </div>
        </div>

        <div class="column-wrapper small horizontal">
            <div class="column column-12">
                <h3 class="description">{{ description }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
    let data = {
        location: '',
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
                        data.location = payload.name;
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
        data: function () {
            return data
        },
        mounted() {
            console.log('Weather/Current component mounted.')
        }
    }
</script>