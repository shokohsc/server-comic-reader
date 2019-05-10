<template>
    <div>
        <h1><a href="/">Home</a></h1>
        <div id="content"></div>
    </div>
</template>

<script>
    import Filebrowser from './Filebrowser.vue';
    import Error from './Error.vue';
    import Loading from './Loading.vue';

    export default {
        components: {
            Filebrowser
        },
        created: function() {
            console.log(Loading);
            var loading = new Loading();
            console.log(loading);
            loading.$mount('#content');

            this.$store.dispatch('files/scan')
            .then((response) => {
                this.$store.commit('files/setFiles', [response]);
                this.$store.commit('router/setKey', { key: response.id });
                var filebrowser = new Filebrowser();
                filebrowser.$mount('#content')
            })
            .catch((error) => {
                this.$store.commit('files/resetFiles');
                this.$store.commit('router/resetKey');
                var error = new Error();
                error.$mount('#content')
            });
        }
    };
</script>
