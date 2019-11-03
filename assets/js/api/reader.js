import $ from 'jquery';

export default {
    scan(success, failure) {
        return $.get('/scan');
    },
    read(path, success, failure) {
        return $.get('/read/' + path);
    },
    preview(path, success, failure) {
        return $.get('/preview/' + path);
    }
};
