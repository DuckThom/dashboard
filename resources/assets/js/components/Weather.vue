<template>
    <div class="panel" id="weather">
        <current></current>

        <hr />

        <forecast></forecast>
    </div>
</template>

<script>
    import Current from './Weather/Current';
    import Forecast from './Weather/Forecast';

    export default {
        components: {
            'current': Current,
            'forecast': Forecast
        },
        mounted() {
            console.log('Weather component mounted.')
        }
    }
</script>