import Vue from 'vue';
import Vuex from 'vuex';
import comic from './modules/comic';
import files from './modules/files';
import router from './modules/router';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        comic,
        files,
        router
    },
    strict: process.env.NODE_ENV !== 'production'
})
