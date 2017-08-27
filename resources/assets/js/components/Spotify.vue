<template>
    <div class="panel" :style="style" id="spotify">
        <div class="title">
            <i class="fa fa-fw fa-music"></i> Spotify
        </div>
        <div class="content">
            <div v-if="authed === 1" id="spotify-authed">
                <div id="album-art-bg-wrapper">
                    <img v-if="music.song.albumArt" :src="music.song.albumArt" />
                </div>

                <div class="song-info">
                    <span class="song-title">{{ music.song.name }}</span>
                    <span class="song-artist">{{ music.song.artist }}</span>
                </div>

                <div class="playback-wrapper">
                    {{ music.playback.now }}

                    <br />

                    {{ music.playback.end }}
                </div>
            </div>
            <div v-else-if="authed === 0">
                <a class="login-button" :href="authUrl">Login via Spotify</a>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .panel {
        background: transparent;
    }
</style>

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
                albumArt: false,
                name: 'Name',
                artist: 'Artist'
            }
        }
    };

    function getMusic() {
        if (data.authed) {
            setTimeout(getMusic, 1000);

            axios.get('/api/music/playing', {
                    timeout: 1500
                })
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
                            albumArt: payload.item.album.images[0].url,
                            name: payload.item.name,
                            artist: payload.item.artists[0].name
                        }
                    };
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }

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