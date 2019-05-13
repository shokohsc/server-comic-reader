import reader from '../../api/reader'

// initial state
const state = {
    key: 0,
    path: '',
    urls: []
}

// getters
const getters = {
    key: state => {
        return state.key;
    },
    path: state => {
        return state.path;
    },
    urls: state => {
        return state.urls;
    }
}

// mutations
const mutations = {
    setKey(state, key) {
        state.key = key;
    },
    resetKey(state) {
        state.key = 0;
    },
    setPath(state, path) {
        state.path = path;
    },
    resetPath(state) {
        state.path = '';
    },
    addUrl(state, url) {
        let found = state.urls.find(element => element === url);
        if (undefined === found) {
            state.urls.push(url);
        }
    },
    setUrls(state, urls) {
        state.urls = urls;
    },
    resetUrls(state) {
        state.urls = [];
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations
}
