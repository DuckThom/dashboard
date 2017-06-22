
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Capitalize the first character of every word in a string
 *
 * @param string
 * @returns {string}
 */
window.capitalize = function(string) {
    var words = string.split(" ");

    for (var i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].substr(1)
    }

    return words.join(" ");
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('github-commits', require('./components/Github/Commits.vue'));
Vue.component('today', require('./components/Today.vue'));
Vue.component('weather', require('./components/Weather.vue'));
Vue.component('news', require('./components/News.vue'));
Vue.component('spotify', require('./components/Spotify.vue'));

const app = new Vue({
    el: '#app',
    components: [
        'today',
        'news',
        'weather',
        'spotify'
    ]
});
