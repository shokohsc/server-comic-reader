<template>
    <div class="files">
        <div v-if="empty" class="nothingfound">
            <div class="nofiles"></div>
            <span>No files here.</span>
        </div>
        <div v-else>
            <ul class="data">
                <Folder :propFolder="folder" v-for="folder in folders" :key="folder.id"></Folder>
                <File :propFile="file" v-for="file in files" :key="file.id"></File>
            </ul>
        </div>
    </div>
</template>

<script>
    import Folder from './Folder.vue';
    import File from './File.vue';

    export default {
        components: {
            Folder,
            File
        },
        computed: {
            files: function() {
                return this.extractDataProperty('files');
            },
            folders: function() {
                return this.extractDataProperty('folders');
            },
            empty: function() {
                return (0 == this.files.length && 0 == this.folders.length);
            }
        },
        methods: {
            parseData: function(data) {
                var self    = this,
                    files   = [],
                    folders = [];

                data.forEach(function(file){
                    if (file.type === 'folder') {
                        self.parseData(file.items);
                        folders.push(file);
                    } else if (file.type === 'file') {
                        files.push(file);
                    }
                });

                return {
                    folders: folders,
                    files: files
                };
            },
            extractDataProperty: function(property) {
                var key = this.$store.getters['router/key'];
                var files = this.$store.getters['files/getFilesInFolderKey'](key);
                if (Array.isArray(files) && 0 < files.length) {
                    files = files[0].items;
                } else if ('object' === typeof files && files.hasOwnProperty('items')) {
                    files = files.items;
                }
                var data = this.parseData(files);

                return data.hasOwnProperty(property) ? data[property] : [];
            }
        }
    };
</script>

<style>
.filemanager .data {
	margin-top: 60px;
	z-index: -3;
}

.filemanager .data.animated {
	-webkit-animation: showSlowlyElement 700ms; /* Chrome, Safari, Opera */
	animation: showSlowlyElement 700ms; /* Standard syntax */
}

.filemanager .data li {
	border-radius: 3px;
	background-color: #373743;
	width: 307px;
	height: 118px;
	list-style-type: none;
	margin: 10px;
	display: inline-block;
	position: relative;
	overflow: hidden;
	padding: 0.3em;
	z-index: 1;
	cursor: pointer;
	box-sizing: border-box;
	transition: 0.3s background-color;
}

.filemanager .data li:hover {
	background-color: #42424E;

}

.filemanager .data li a {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

.filemanager .data li .name {
	color: #ffffff;
	font-size: 15px;
	font-weight: 700;
	line-height: 20px;
	width: 150px;
	white-space: nowrap;
	display: inline-block;
	position: absolute;
	overflow: hidden;
	text-overflow: ellipsis;
	top: 40px;
}

.filemanager .data li .details {
	color: #b6c1c9;
	font-size: 13px;
	font-weight: 400;
	width: 55px;
	height: 10px;
	top: 64px;
	white-space: nowrap;
	position: absolute;
	display: inline-block;
}

.filemanager .nothingfound {
	background-color: #373743;
	width: 23em;
	height: 21em;
	margin: 0 auto;
	display: block;
	font-family: Arial;
	-webkit-animation: showSlowlyElement 700ms; /* Chrome, Safari, Opera */
	animation: showSlowlyElement 700ms; /* Standard syntax */
}

.filemanager .nothingfound .nofiles {
	margin: 30px auto;
	top: 3em;
	border-radius: 50%;
	position:relative;
	background-color: #d72f6e;
	width: 11em;
	height: 11em;
	line-height: 11.4em;
}
.filemanager .nothingfound .nofiles:after {
	content: '×';
	position: absolute;
	color: #ffffff;
	font-size: 14em;
	margin-right: 0.092em;
	right: 0;
}

.filemanager .nothingfound span {
	margin: 0 auto auto 6.8em;
	color: #ffffff;
	font-size: 16px;
	font-weight: 700;
	line-height: 20px;
	height: 13px;
	position: relative;
	top: 2em;
}

@media all and (max-width:965px) {

	.filemanager .data li {
		width: 100%;
		margin: 5px 0;
	}

}

/* Chrome, Safari, Opera */
@-webkit-keyframes showSlowlyElement {
	100%   	{ transform: scale(1); opacity: 1; }
	0% 		{ transform: scale(1.2); opacity: 0; }
}

/* Standard syntax */
@keyframes showSlowlyElement {
	100%   	{ transform: scale(1); opacity: 1; }
	0% 		{ transform: scale(1.2); opacity: 0; }
}
</style>
