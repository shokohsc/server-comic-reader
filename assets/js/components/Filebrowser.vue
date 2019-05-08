<template>
    <div class="filemanager">
        <Search :key="key + '-search'"></Search>
        <Breadcrumb :key="key + '-breadcrumb'"></Breadcrumb>
        <Files :key="key + '-files'"></Files>
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
        data: function () {
            return {
                key: 0,
            }
        },
        methods: {
            forceRerender() {
                this.key += 1
            }
        },
        created: function () {
            this.$store.dispatch('files/scan')
            .then((response) => {
                this.$store.commit('files/setFiles', { files: [response] });
                this.forceRerender();
            })
            .catch((error) => {
                this.$store.commit('files/resetFiles');
                this.forceRerender();
            });
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
