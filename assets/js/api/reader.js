import $ from 'jquery';

export default {
    scan(success, failure) {
        return $.get('/scan');
    },
    read(path, success, failure) {
        return $.get({
            url: '/read/' + path,
            beforeSend: xhr => xhr.setRequestHeader('X-Downlink', navigator.connection.downlink),
        });
    },
    preview(path, success, failure) {
        return $.get('/preview/' + path);
    }
};
