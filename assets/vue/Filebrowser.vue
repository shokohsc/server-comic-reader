<template>
    <div class="filemanager">
        <Search :initialFiles="files"></Search>
        <Breadcrumb :propFiles="files"></Breadcrumb>
        <Files></Files>
    </div>
</template>

<script>
    import Breadcrumb from './Breadcrumb.vue';
    import Files from './Files.vue';
    import Search from './Search.vue';

    export default {
        components: {
            Breadcrumb,
            Files,
            Search
        },
        computed: {
            files () {
                return this.$store.state.files
            }
        },
        methods: {
            scan: function() {
                var self = this;
                $.get('/scan').then(response => {
                    $.each(response.items, function (key, value) {
                        self.$store.commit('addFiles', value);
                    });
                });
            }
        },
        created: function () {
            this.scan();
        }
    }
</script>

<style>
.filemanager {
	width: 95%;
	max-width:1340px;
	position: relative;
	margin: 100px auto 50px;
}

@media all and (max-width: 965px) {
	.filemanager {
		margin: 30px auto 0;
		padding: 1px;
	}
}
</style>
