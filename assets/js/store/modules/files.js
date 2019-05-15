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
    },
    search: (state, getters) => value => {
        let found = [];
        const regex = new RegExp('(' + value + ')', 'g');
        const search = (files, regex) => {
            files.forEach(file => {
                if (file.name.toLowerCase().match(regex)) {
                    found.push(file);
                } else if ('folder' === file.type && !file.name.toLowerCase().match(regex)){
                    search(file.items, regex);
                }
            });
        };

        search(getters.files, regex);

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
