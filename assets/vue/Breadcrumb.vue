<template>
    <div class="breadcrumbs">
        <div v-for="folder in previous">
            <span @click="browse" class="folderName">{{ folder.name }}</span>
            <span class="arrow">→</span>
        </div>
        <span class="folderName">{{ last }}</span>
    </div>
</template>

<script>
    export default {
        props: ['propFiles'],
        data: function () {
            return {
                path: '',
                urls: [],
                files: this.propFiles,
                previous: [],
                last: ''
            }
        },
        methods: {
            browse: function (event) {
                if (event) {
                    var $target = $(event.target);
                    var index = $target.find('a').index($target),
                        nextDir = $target[index];
                    this.urls.length = Number(index);
                    window.location.hash = encodeURIComponent(nextDir);
                }
            },
            goto: function (hash) {
                hash = decodeURIComponent(hash).slice(1).split('=');
                if (hash.length && 0 < this.files.length) {
                    var rendered = '';
                    // if hash has search in it
                    if (hash[0] === 'search') {
                        rendered = parseData(this.files);
                        if (rendered.length) {
                            this.path = hash[0];
                            this.render(rendered);
                        } else {
                            this.render(rendered);
                        }
                    // if hash is some path
                    } else if (hash[0].trim().length) {
                        rendered = this.searchByPath(hash[0]);
                        if (rendered.length) {
                            this.path = hash[0];
                            this.urls = this.generateBreadcrumbs(hash[0]);
                            this.render(rendered);
                        } else {
                            this.path = hash[0];
                            this.urls = this.generateBreadcrumbs(hash[0]);
                            this.render(rendered);
                        }
                    // if there is no hash
                    } else {
                        this.path = this.files[0].path;
                        this.urls.push(this.path);
                        this.render(this.searchByPath(this.path));
                    }
                }
            },
            render: function (data) {
                var self = this;
                this.urls.forEach(function (u, i) {
                    var name = u.split('/');
                    if (i !== self.urls.length - 1) {
                        self.previous.push({
                            path: u,
                            name: name[name.length - 1]
                        });
                    } else {
                        self.last = name[name.length - 1];
                    }
                });
            },
            searchByPath: function (dir) {
                var path = dir.split('/'),
                    demo = this.propFiles,
                    flag = 0;

                for(var i = 0; i < path.length; i++){
                    for(var j = 0; j < demo.length; j++){
                        if(demo[j].name === path[i]){
                            flag = 1;
                            demo = demo[j].items;
                            break;
                        }
                    }
                }

                demo = flag ? demo : [];
                return demo;
            },
            parseData: function (data) {
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
            generateBreadcrumbs: function (nextDir) {
                var path = nextDir.split('/').slice(0);
                for(var i = 1; i < path.length; i++){
                    path[i] = path[i - 1]+ '/' +path[i];
                }
                return path;
            }
        },
        created: function() {
            this.goto(window.location.hash);
        }
    }
</script>

<style>
.filemanager .breadcrumbs {
	color: #ffffff;
	margin-left:20px;
	font-size: 24px;
	font-weight: 700;
	line-height: 35px;
}

.filemanager .breadcrumbs a:link, .breadcrumbs a:visited {
	color: #ffffff;
	text-decoration: none;
}

.filemanager .breadcrumbs a:hover {
	text-decoration: underline;
}

.filemanager .breadcrumbs .arrow {
	color:  #6a6a72;
	font-size: 24px;
	font-weight: 700;
	line-height: 20px;
}
</style>
