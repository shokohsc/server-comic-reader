<template>
    <div id="app">
        <Photoswipe></Photoswipe>
        <Filebrowser></Filebrowser>
    </div>
</template>

<script>
    import Filebrowser from './Filebrowser.vue';
    import Photoswipe from './Photoswipe.vue';

    export default {
        components: {
            Filebrowser,
            Photoswipe
        }
    }
</script>

<style>
    .hidden {
    	display: none;
    }

    .visible {
    	display: block;
    }
</style>
