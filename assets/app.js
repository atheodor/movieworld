/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const $ = require('jquery');

require('bootstrap');

import Vue from 'vue';
import App from './App.vue';

new Vue({
    el: "#app",
    components: {App}
})

switch(window.activeFilter) {
    case 'likes':
        $('#likesFilter').prop('checked', true);
        break;
    case 'hates':
        $('#hatesFilter').prop('checked', true);
        break;
    default:
        $('#datesFilter').prop('checked', true);
}

$('#likesFilter').change(function() {
    $('#hatesFilter').prop('checked', false);
    $('#datesFilter').prop('checked', false);
    window.location.replace("/?filter=likes");
});

$('#hatesFilter').change(function() {
    $('#likesFilter').prop('checked', false);
    $('#datesFilter').prop('checked', false);
    window.location.replace("/?filter=hates");
});

$('#datesFilter').change(function() {
    $('#hatesFilter').prop('checked', false);
    $('#likesFilter').prop('checked', false);
    window.location.replace("/");
});