<template>
    <div class="column column-6">
        <div class="panel">
            <div class="title">Commits</div>

            <div class="chart-wrapper">
                <canvas id="commitChart"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
    function fetchGithubCommitData() {
        axios.get('/github/commits')
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    fetchGithubCommitData();
    setInterval(fetchGithubCommitData, 10000);

    export default {
        mounted() {
            window.commitChart = new Chart(document.getElementById("commitChart"), {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    datasets: [{
                        label: '# of Votes',
                        data: [62,59,89,47,24,60,40,12,94,45,65,8],
                        borderColor: '#FFE57F',
                        backgroundColor: 'transparent',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                display: false
                            }
                        }]
                    }
                }
            });

            console.log('Github commits component mounted.')
        }
    }
</script>