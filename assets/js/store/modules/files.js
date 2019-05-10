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
    getFilesInFolder: (state) => (folder) => {
        console.log('folder', folder);
        return state.files.find((element) => {
            if (element.path === folder && 'folder' === element.type) {
                console.log('files', element);
                return element;
            }
            if (element.path !== folder && 'folder' === element.type) {
                console.log('files', element);
                return this.getFilesInFolder(folder);
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
