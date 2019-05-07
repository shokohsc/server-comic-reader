<template>
    <div class="filemanager">
        <Search :initialFiles.sync="files"></Search>
        <Breadcrumb :propFiles.sync="files"></Breadcrumb>
        <Files :propFiles.sync="files"></Files>
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
                // files: []
                files: [{
                    id: '45b963397aa40d4a0063e0d85e4fe7a1',
                    items: [
                        {
                            id: 'cd043010c87285aa9b4f9792c2ee907c',
                            items: [],
                            name: 'marvel week',
                            path: 'files/marvel week',
                            type: 'folder'
                        },
                        {
                            id: 'e4b18e540a097d71829b0cbadd505456',
                            items: [
                                {
                                id: '344ab7b27d84ebd0e7db3a4ce6661332',
                                name: 'Batman - The Merciless 001 (2017) (Digital) (Zone-Empire).cbr',
                                path: 'files/dc events/Batman - The Merciless 001 (2017) (Digital) (Zone-Empire).cbr',
                                type: 'file',
                                size: 44475896
                                }
                            ],
                            name: 'dc events',
                            path: 'files/dc events',
                            type: 'folder'
                        }
                    ],
                    name: 'files',
                    path: 'files',
                    type: 'folder'
                }]
            }
        },
        methods: {
            scan: function() {
                $.get('/scan').then(response => {
                    this.files = [response];
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
