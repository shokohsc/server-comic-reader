<template>
    <div id="app">
        <!-- <Photoswipe></Photoswipe> -->
        <Filebrowser></Filebrowser>
    </div>
</template>

<script>
    import Photoswipe from './Photoswipe.vue';
    import Filebrowser from './Filebrowser.vue';

    export default {
        components: {
            Photoswipe,
            Filebrowser
        }
    }
</script>
