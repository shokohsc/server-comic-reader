import reader from '../../api/reader'

// initial state
const state = {
    files: []
}

// getters
const getters = {
    files: state => {
        return state.files;
    }
}

// actions
const actions = {
    scan({ commit }) {
        return reader.scan();
        // reader.scan(
        //     (files) => commit('setFiles', { files: [files] }),
        //     () => commit('resetFiles')
        // )
    }
}

// mutations
const mutations = {
    setFiles(state, files) {
        state.files = files;
    },
    resetFiles(state) {
        state.files = [];
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
