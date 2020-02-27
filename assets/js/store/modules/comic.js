import reader from '../../api/reader'

// initial state
const state = {
    comic: [],
    index: 0,
    total: 0,
}

// getters
const getters = {
    comic: state => {
        return state.comic;
    },
    index: state => {
        return state.index;
    },
    total: state => {
        return state.comic.length;
    },
    page: state => {
        return state.comic[state.index];
    }
}

// actions
const actions = {
    read({}, path) {
        return reader.read(path);
    },
    preview({}, path) {
        return reader.preview(path);
    }
}

// mutations
const mutations = {
    setComic(state, comic) {
        state.comic = comic;
    },
    resetComic(state) {
        state.comic = [];
    },
    setIndex(state, index) {
        state.index = index;
    },
    increaseIndex(state) {
        const index = state.index += (state.index < state.comic.length - 1) ? 1 : 0;
        this.commit('comic/setIndex', index);
    },
    decreaseIndex(state) {
        const index = state.index -= (state.index > 0) ? 1 : 0;
        this.commit('comic/setIndex', index);
    },
    resetIndex(state) {
        state.index = 0;
    },
    reset(state) {
        this.commit('comic/resetComic');
        this.commit('comic/resetIndex');
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
