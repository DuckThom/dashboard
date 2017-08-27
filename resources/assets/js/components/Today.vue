<template>
    <div class="panel" :style="style" id="today">
        <div class="content text-center">
            <div class="date">{{ date }}</div>
            <div class="time">{{ now }}</div>
        </div>
    </div>
</template>

<style scoped>
    .panel {
        background: white;
        color: #333;
    }
</style>

<script>
    let hideSeparator = false;
    let data = {
        now: moment().format('HH:mm'),
        date: window.capitalize(moment().locale('nl').format('dddd D MMMM YYYY'))
    };

    setInterval(function () {
        hideSeparator = !hideSeparator;

        if (hideSeparator) {
            data.now = moment().format('HH mm');
        } else {
            data.now = moment().format('HH:mm');
        }

        let today = moment().locale('nl').format('dddd D MMMM YYYY');

        data.date = window.capitalize(today);
    }, 1000);

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
            console.log('Today component mounted.')
        }
    }
</script>