import $ from 'jquery';

export default {
    scan(success, failure) {
        return $.get('/scan');
            // .then(response => {
            //     console.log(response);
            //     success(response);
            // }).catch(error => {
            //     console.log(error);
            //     failure(response);
            // });
    },
    read(path, success, failure) {
        return $.get('/read/' + path);
            // .then(response => {
            //     console.log(response);
            //     success(response);
            // }).catch(error => {
            //     console.log(error);
            //     failure(response);
            // });
    }
};
