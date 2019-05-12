<template>
    <div>
        <component :is="activeComponent"></component>
    </div>
</template>

<script>
    import Filebrowser from './Filebrowser.vue';
    import Error from './Error.vue';
    import Loading from './Loading.vue';
    import Reader from './Reader.vue';

    export default {
        components: {
            Filebrowser,
            Loading,
            Error,
            Reader
        },
        data() {
            return {
                activeComponent: Loading
            }
        },
        methods: {
            loading: function() {
                this.activeComponent = Loading;
            },
            clear: function() {
                this.$store.commit('comic/reset');
                this.activeComponent = Filebrowser;
            },
            display: function(data) {
                this.$store.commit('comic/setComic', data);
                this.activeComponent = Reader;
            }
        },
        created: function() {
            this.$store.dispatch('files/scan')
            .then((response) => {
                this.$store.commit('files/setFiles', [response]);
                this.$store.commit('router/setPath', encodeURIComponent(response.path));
                this.$store.commit('router/addUrl', response.path);
                this.$store.commit('router/setKey', response.id);
                this.activeComponent = Filebrowser;
            })
            .catch((error) => {
                console.log(error);
                this.$store.commit('files/resetFiles');
                this.$store.commit('router/resetKey');
                this.activeComponent = Error;
            });

            let self = this;
            this.$eventBus.$on('loading-comic', () => self.loading());
            this.$eventBus.$on('display-comic', (data) => self.display(data));
            this.$eventBus.$on('close-comic', () => self.clear());
        }
    };
</script>
