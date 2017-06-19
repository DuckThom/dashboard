<template>
    <div class="panel" id="today">
        <div class="content text-center">
            <div class="date">{{ date }}</div>
            <div class="time">{{ now }}</div>
        </div>
    </div>
</template>

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
        data: function () {
            return data
        },
        mounted() {
            console.log('Today component mounted.')
        }
    }
</script>