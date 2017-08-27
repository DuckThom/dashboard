<template>
    <div :style="style" id="stash">
        <div v-for="commit in commits" class="panel item">
            <div class="title">
                {{ commit.title }}
            </div>
            <div class="content">
                <p class="description" v-html="commit.description"></p>
            </div>
            <div class="footer">
                {{ commit.dateString }}
            </div>
        </div>
    </div>
</template>

<style scoped>
    #stash {
        display: grid;
        grid-auto-rows: 90px;
        grid-row-gap: 1.5vh;
        overflow-y: hidden;
    }

    .description {
        margin: 0;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .panel {
        height: 90px
    }

    .title {
        font-size: 1.25em;
    }
</style>

<script>
    let lastEsbCommit = "";
    let lastMagentoCommit = "";
    let data = {
        commits: []
    };

    function getZegroEsbCommits () {
        axios.get('/api/stash/esb-commits?from=' + lastEsbCommit, {
                timeout: 5000
            })
            .then(function (response) {
                const responseData = response.data;

                let hash = convertResponseData(responseData);

                if (hash) {
                    lastEsbCommit = hash;
                }

                sortCommits();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function getZegroMagentoCommits () {
        axios.get('/api/stash/magento-commits?from=' + lastMagentoCommit, {
                timeout: 5000
            })
            .then(function (response) {
                const responseData = response.data;

                let hash = convertResponseData(responseData);

                if (hash) {
                    lastMagentoCommit = hash;
                }

                sortCommits();
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function convertResponseData (responseData) {
        if (responseData.code === 200) {
            let commits = [];

            responseData.payload.values.forEach(function (commit) {
                commits.push(convertResponseCommit(commit))
            });

            data.commits = data.commits.concat(commits);

            return commits[0].hash;
        }

        return false;
    }

    function convertResponseCommit (commit) {
        let message = commit.message.replace("\n", "");

        return {
            hash: commit.id,
            title: commit.displayId + ' - ' + commit.author.displayName,
            description: message,
            timestamp: commit.committerTimestamp,
            dateString: moment(commit.committerTimestamp).calendar()
        };
    }

    function sortCommits() {
        data.commits.sort(function (a, b) {
            return ( a.timestamp > b.timestamp ? -1 : ( a.timestamp < b.timestamp ? 1 : 0 ));
        });
    }

    export default {
        props: ['area'],
        computed: {
            style () {
                return 'grid-area: ' + this.area;
            }
        },
        data: function () {
            return data;
        },
        mounted: function () {
            setInterval(getZegroMagentoCommits, 10000);
            setInterval(getZegroEsbCommits, 10000);
            getZegroMagentoCommits();
            getZegroEsbCommits();

            console.log('Stash commits component mounted');
        }
    }
</script>