import reader from '../../api/reader'

// initial state
const state = {
    path: '',
    urls: []
}

// getters
const getters = {
    path: state => {
        return state.path;
    },
    urls: state => {
        return state.urls;
    }
}

// mutations
const mutations = {
    setPath(state, path) {
        state.path = path;
    },
    resetPath(state) {
        state.path = '';
    },
    addUrl(state, url) {
        state.urls.push(url);
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
