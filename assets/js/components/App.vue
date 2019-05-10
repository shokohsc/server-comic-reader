<template>
    <div>
        <h1><a href="/">Home</a></h1>
        <component :is="activeComponent"></component>
    </div>
</template>

<script>
    import Filebrowser from './Filebrowser.vue';
    import Error from './Error.vue';
    import Loading from './Loading.vue';

    export default {
        components: {
            Filebrowser,
            Loading,
            Error
        },
        data() {
            return {
                activeComponent: Loading
            }
        },
        created: function() {
            this.$store.dispatch('files/scan')
            .then((response) => {
                this.$store.commit('files/setFiles', [response]);
                this.$store.commit('router/setKey', { key: response.id });
                this.activeComponent = Filebrowser;
            })
            .catch((error) => {
                this.$store.commit('files/resetFiles');
                this.$store.commit('router/resetKey');
                this.activeComponent = Error;
            });
        }
    };
</script>
