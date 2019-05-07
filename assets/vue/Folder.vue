<template>
    <li @click.stop.prevent="browse" class="folders">
        <a :href="folder.path" :title="folder.path" class="folders">
            <span :class="folder.class"></span>
            <span class="name">{{ folder.name }}</span>
            <span class="details">{{ folder.itemsLength }}</span>
        </a>
    </li>
</template>

<script>
    export default {
        props: ['propFolder'],
        data: function () {
            return {
                folder: {
                    id: '',
                    path: '',
                    type: '',
                    class: '',
                    name: '',
                    itemsLength: 'Empty',
                    items: []
                }
            }
        },
        methods: {
            browse: function (event) {
                if (event) {
                    var $target = $(event.target);
                    window.location.hash = encodeURIComponent($target.attr('href'));
                }
            },
            escapeHTML: function (text) {
                return text.replace(/\&/g,'&amp;').replace(/\</g,'&lt;').replace(/\>/g,'&gt;');
            }
        },
        created: function () {
            this.folder.id = this.propFolder.id;
            this.folder.path = this.propFolder.path;
            this.folder.type = this.propFolder.type;
            this.folder.items = this.propFolder.items;
            this.folder.name = this.escapeHTML(this.propFolder.name);
            this.folder.class = 'icon folder';
            if (0 < this.propFolder.items.length) {
                this.folder.class = 'icon folder full';
                this.folder.itemsLength = this.propFolder.items.length + ' items';
            }
            if (1 == this.propFolder.items.length) {
                this.folder.itemsLength = '1 item';
            }
        }
    }
</script>

<style>
.icon {
	font-size: 23px;
}
.icon.folder {
	display: inline-block;
	margin: 1em;
	background-color: transparent;
	overflow: hidden;
}
.icon.folder:before {
	content: '';
	float: left;
	background-color: #7ba1ad;

	width: 1.5em;
	height: 0.45em;

	margin-left: 0.07em;
	margin-bottom: -0.07em;

	border-top-left-radius: 0.1em;
	border-top-right-radius: 0.1em;

	box-shadow: 1.25em 0.25em 0 0em #7ba1ad;
}
.icon.folder:after {
	content: '';
	float: left;
	clear: left;

	background-color: #a0d4e4;
	width: 3em;
	height: 2.25em;

	border-radius: 0.1em;
}
.icon.folder.full:before {
	height: 0.55em;
}
.icon.folder.full:after {
	height: 2.15em;
	box-shadow: 0 -0.12em 0 0 #ffffff;
}
</style>
