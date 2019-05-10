import reader from '../../api/reader'

// initial state
const state = {
    files: []
}

// getters
const getters = {
    files: state => {
        return state.files;
    },
    getFilesInFolderKey: (state, getters) => (key) => {
        return state.files.find((element) => {
            if (element.id === key && 'folder' === element.type) {
                return element;
            }
            if (element.id !== key && 'folder' === element.type) {
                return getters.getFilesInFolderKey(element.id);
            }
        });
    }
}

// actions
const actions = {
    scan({ commit }) {
        return reader.scan();
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
