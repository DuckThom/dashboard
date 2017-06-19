<template>
    <div class="panel" id="spotify">
        <div class="content">
            <div v-if="authed === 1">
                <h2 v-if="music.playing">Now playing</h2>
                <h2 v-else="music.playing">Recently played</h2>

                <div class="song-info">
                    <span class="song-title">{{ music.song.name }}</span>
                    <span class="song-artist">{{ music.song.artist }}</span>
                </div>

                <div class="playback-wrapper">
                    <span class="playback-time">{{ music.playback.now }}</span> / <span class="playback-end">{{ music.playback.end }}</span>
                </div>
            </div>
            <div v-else-if="authed === 0">
                <a class="login-button" :href="authUrl">Login with Spotify</a>
            </div>
        </div>
    </div>
</template>

<script>
    let data = {
        authed: -1,
        authUrl: "",
        token: false,

        music: {
            playing: false,
            playback: {
                now: '00:00',
                end: '00:00'
            },
            song: {
                name: 'Song name',
                artist: 'Artist'
            }
        }
    };

    function getMusic() {
        if (data.authed) {
            axios.get('/api/music/playing')
                .then(function(response) {
                    let responseData = response.data;
                    let payload = JSON.parse(responseData.payload);

                    data.music = {
                        playing: payload.is_playing,
                        playback: {
                            now: numeral(Math.floor(payload.progress_ms / 1000)).format('h:mm:ss'),
                            end: numeral(Math.floor(payload.item.duration_ms / 1000)).format('h:mm:ss')
                        },
                        song: {
                            name: payload.item.name,
                            artist: payload.item.artists[0].name
                        }
                    };

                    getMusic();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }

    export default {
        data: function () {
            return data
        },
        mounted() {
            axios.get('/api/music/token')
                .then(function (response) {
                    let responseData = response.data;
                    let payload = responseData.payload;
                    console.log(payload);

                    if (typeof payload.token === "undefined") {
                        data.authed = 0;
                        data.authUrl = payload.authUrl;
                    } else {
                        data.authed = 1;
                        data.token = payload.token;

                        getMusic();
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });

            console.log('Spotify component mounted.')
        }
    }
</script>