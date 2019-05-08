import reader from '../../api/reader'

// initial state
const state = {
    comic: {}
}

// getters
const getters = {
    comic: state => {
        return state.comic;
    }
}

// actions
const actions = {
    read({ commit }, path) {
        return reader.read(path);
        // reader.read(
        //     (path) => commit('setComic', { comic: comic }),
        //     () => commit('resetComic')
        // )
    }
}

// mutations
const mutations = {
    setComic(state, comic) {
        state.comic = comic;
    },
    resetComic(state) {
        state.comic = {};
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
