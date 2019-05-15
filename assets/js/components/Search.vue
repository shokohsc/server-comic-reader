<template>
    <div @click="toggle" @focusout="clear" class="search">
        <input @input="search" @keyup.esc="clear" type="search" placeholder="Find a file.."/>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                currentPath: ''
            }
        },
        methods: {
            toggle: function(event) {
                if (event) {
                    let $target = $(event.target);
                    $target.find('input[type=search]').show().focus();
                }
            },
            search: function(event) {
                if (event) {
                    let target = $(event.target)[0];
                    let value  = target.value.trim();

                    if (1 < value.length) {
                        let path = 'search=' + value
                        window.location.hash = path;
                        this.$store.commit('router/addUrl', path);
                        this.$store.commit('router/setPath', encodeURIComponent(path));
                        this.$store.commit('router/setKey', btoa(path));
                        window.location.hash = encodeURIComponent(path);
                    }
                }
            },
            clear: function(event) {
                if (event) {
                    let target = $(event.target)[0];

                    window.location.hash = encodeURIComponent(this.currentPath);
                    $(target).hide();
                    $(target).parent().find('span').show();
                }
            }
        }
    };
</script>

<style>
.filemanager .search {
	position: absolute;
    margin-left: 23px;
    margin-top: 10px;
	cursor: pointer;
	font-size: 17px;
	color: #ffffff;
	display: block;
}

.filemanager .search:before {
	content: '';
	position: absolute;
	margin-top:12px;
	width: 10px;
	height: 11px;
	border-radius: 50%;
	border: 2px solid #ffffff;
}

.filemanager .search:after {
	content: '';
	width: 3px;
	height: 10px;
	background-color: #ffffff;
	border-radius: 2px;
	position: absolute;
	top: 23px;
    left: 14px;
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
}

.filemanager .search input[type=search] {
	border-radius: 2px;
	color: #4D535E;
	background-color: #FFF;
	width: 250px;
	height: 44px;
    margin-left: 30px;
    margin-right: 20px;
	padding-left: 20px;
	text-decoration-color: #4d535e;
	font-size: 16px;
	font-weight: 400;
	line-height: 20px;
	display: none;
	outline: none;
	border: none;
	padding-right: 10px;
	-webkit-appearance: none;
}

::-webkit-input-placeholder { /* WebKit browsers */
	color:    #4d535e;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
	color:    #4d535e;
	opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
	color:    #4d535e;
	opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
	color:    #4d535e;
}
</style>
