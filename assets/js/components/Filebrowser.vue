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
        computed: {
            key: function() {
                return this.$store.getters['router/key'].key;
            }
        }
    };
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
