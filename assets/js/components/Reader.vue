<template>
    <v-touch @swipeleft="nextPage" @swiperight="previousPage">
        <div :style="{ height: height + 'px' }" v-dragscroll.y="true">
            <div v-on:click="previousPage" class="left"></div>
            <div v-on:click="close" class="center"></div>
            <div v-on:click="nextPage" class="right"></div>
            <img :src="image" :width="width" class="image"/>
            <p class="pages glow">{{ page }} / {{ total }}</p>
        </div>
    </v-touch>
</template>

<script>
    export default {
        computed: {
            index: function() {
                return this.$store.getters['comic/index'];
            },
            page: function() {
                return this.$store.getters['comic/index'] + 1;
            },
            total: function() {
                return this.$store.getters['comic/total'];
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
            },
            scroll: function(event) {
                let speed = Math.abs(event.overallVelocityY);
                    speed = Math.floor(speed) > 0 ? speed : 1;
                const scroll = {
                    top: Math.floor((window.scrollY - event.deltaY) * speed),
                    behavior: 'smooth'
                };
                window.scroll(scroll);
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
    cursor: w-resize;
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
    cursor: not-allowed;
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
    cursor: e-resize;
    /* opacity: 0.5;
    background-color: #00F; */
}
.image {
    position: absolute;
    left: 0;
    z-index: -1;
    width: 100%;
}
.pages {
    position: absolute;
    top: 1%;
    width: 100%;
    opacity: 0.2;
    pointer-events: none;
    font-family: monospace;
}
.glow {
  font-size: 80px;
  color: #fff;
  text-align: center;
  -webkit-animation: glow 1s ease-in-out infinite alternate;
  -moz-animation: glow 1s ease-in-out infinite alternate;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #000, 0 0 20px #000, 0 0 30px #0032e6, 0 0 40px #0032e6, 0 0 50px #0032e6, 0 0 60px #0032e6, 0 0 70px #0032e6;
  }
  to {
    text-shadow: 0 0 20px #000, 0 0 30px #4d62ff, 0 0 40px #4d62ff, 0 0 50px #4d62ff, 0 0 60px #4d62ff, 0 0 70px #4d62ff, 0 0 80px #4d62ff;
  }
}
</style>
