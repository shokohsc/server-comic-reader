/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

import App from '../vue/App.vue';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        files: []
    },
    getters: {
        getFiles: state => {
            return state.files;
        },
        getFilesInFolder: (state) => (folder) => {
            return state.files.find(files => files.name === folder)
        }
    },
    mutations: {
        addFiles(state, payload) {
            state.files.push(payload);
        }
    }
});

/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    store,
    render: h => h(App)
});
