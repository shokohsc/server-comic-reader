<template>
    <div class="breadcrumbs">
        <div v-for="link in links" @click.capture="browse" class="inline">
            <a @click.stop.prevent :href="link.path" :title="link.path">
                <span class="folderName">{{ link.name }}</span>
            </a>
            <span class="arrow">→ </span>
        </div>
        <div class="inline">
            <span class="folderName">{{ last }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            links: function() {
                let folders = this.folder.path.split('/');
                let path = [];
                let links = [];
                folders.pop();
                folders.forEach(folder => {
                    path.push(folder);
                    links.push({
                        name: folder,
                        path: path.join('/')
                    });
                }, this);

                return links;
            },
            last: function() {
                return this.folder.path.split('/').pop();
            },
            key: function() {
                return this.$store.getters['router/key'];
            },
            folder: function() {
                const isSearch = 0 === atob(this.key).indexOf('search=');
                if (isSearch) {
                    const value = atob(this.key).substring(('search=').length);
                    return {
                        id: this.key,
                        name: 'files/search/' + value,
                        type: 'folder',
                        path: 'files/search/' + value,
                        items: this.$store.getters['files/search'](value)
                    };
                }

                return this.$store.getters['files/folderWithId'](this.key);
            }
        },
        methods: {
            browse: function (event) {
                if (event) {
                    let folder = event.target.textContent,
                        urls = this.$store.getters['router/urls'],
                        nextDir = '';
                    for (let i = 0; i < urls.length; i++) {
                        let condition = (0 <= urls[i].indexOf(folder));
                        if (condition && 'search' !== urls[i]) {
                            nextDir = urls[i];
                            break;
                        }
                    }
                    let key = btoa(nextDir);
                    this.$store.commit('router/setKey', key);
                    this.$store.commit('router/setPath', encodeURIComponent(this.folder.path));
                    this.$store.commit('router/addUrl', this.folder.path);
                    window.location.hash = encodeURIComponent(nextDir);
                }
            }
        }
    };
</script>

<style>
.inline {
    display: inline;
}

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
