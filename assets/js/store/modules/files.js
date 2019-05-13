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
    filesInFolderWithId: (state, getters) => id => {
        const folders = (files) => files.filter(file => file.type === 'folder');
        const search = (files, id) => {
            return folders(files).find(file => {
                if (file.id === id) {
                    found = file;
                }
                return file.id === id || search(file.items, id);
            });
        };
        let found = getters.files;
        search(getters.files, id);

        return found.items;
    },
    folderWithId: (state, getters) => id => {
        const folders = (files) => files.filter(file => file.type === 'folder');
        const search = (files, id) => {
            return folders(files).find(file => {
                if (file.id === id) {
                    found = file;
                }
                return file.id === id || search(file.items, id);
            });
        };
        let found = getters.files;
        search(getters.files, id);

        return found;
    }
}

// actions
const actions = {
    scan() {
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
