<template>
    <v-touch @swipeleft="nextPage" @swiperight="previousPage">
        <div :style="{ height: height + 'px' }">
            <div v-on:click="previousPage" class="left"></div>
            <div v-on:click="close" class="center"></div>
            <div v-on:click="nextPage" class="right"></div>
            <img :src="image" :width="width" class="image"/>
        </div>
    </v-touch>
</template>

<script>
    export default {
        computed: {
            index: function() {
                return this.$store.getters['comic/index'];
            },
            image: function() {
                return 'data:' + this.type + ';base64,' + this.$store.getters['comic/page']['image'];
            },
            width: function() {
                return window.screen.availWidth;
            },
            height: function() {
                let height = this.$store.getters['comic/page']['height'] * this.width / this.$store.getters['comic/page']['width'];
                return Math.floor(height);
            },
            type: function() {
                return this.$store.getters['comic/page']['type'];
            },
        },
        methods: {
            close: function() {
                this.$eventBus.$emit('close-comic');
            },
            nextPage: function() {
                this.$store.commit('comic/increaseIndex');
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            },
            previousPage: function() {
                this.$store.commit('comic/decreaseIndex');
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            },
            keyUp: function(event) {
                switch (event.keyCode) {
                    case 39:
                        this.nextPage();
                        break;
                    case 27:
                        this.close();
                        break;
                    case 37:
                        this.previousPage();
                        break;
                }
            }
        },
        created: function() {
            window.addEventListener('keyup', this.keyUp);
        },
        destroyed: function() {
            window.removeEventListener('keyup', this.keyUp);
        }
    };
</script>

<style>
.left {
    position: absolute;
    left: 0;
    z-index: 1;
    height: inherit;
    width: 40%;
    display: inline-block;
    /* opacity: 0.5;
    background-color: #F00; */
}
.center {
    position: absolute;
    left: 40%;
    z-index: 1;
    height: inherit;
    width: 20%;
    display: inline-block;
    /* opacity: 0.5;
    background-color: #0F0; */
}
.right {
    position: absolute;
    left: 60%;
    z-index: 1;
    height: inherit;
    width: 40%;
    display: inline-block;
    /* opacity: 0.5;
    background-color: #00F; */
}
.image {
    position: absolute;
    left: 0;
    z-index: -1;
    width: 100%;
}
</style>
