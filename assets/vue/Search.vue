<template>
    <div @click="toggle" class="search">
        <input @input="search" @keyup.27="clear" type="search" placeholder="Find a file.."/>
    </div>
</template>

<script>
    export default {
        props: ['files'],
        data: function () {
            return {
                currentPath: ''
            }
        },
        methods: {
            toggle: function(event) {
                if (event) {
                    var $target = $(event.target);
                    $target.find('span').hide();
                    $target.find('input[type=search]').show().focus();
                }
            },
            search: function(event) {
                if (event) {
                    var target = $(event.target)[0];
                    var value  = target.value.trim();

                    window.location.hash = encodeURIComponent(this.currentPath);
                    if (value.length) {
                        window.location.hash = 'search=' + value.trim();
                    }
                }
            },
            clear: function(event) {
                if (event) {
                    var target = $(event.target)[0];

                    if (!target.value.trim().length) {
                        window.location.hash = encodeURIComponent(this.currentPath);
                        $(target).hide();
                        $(target).parent().find('span').show();
                    }
                }
            }
        }
    }
</script>

<style>
.filemanager .search {
	position: absolute;
	padding-right: 30px;
	cursor: pointer;
	right: 0;
	font-size: 17px;
	color: #ffffff;
	display: block;
	width: 40px;
	height: 40px;
}

.filemanager .search:before {
	content: '';
	position: absolute;
	margin-top:12px;
	width: 10px;
	height: 11px;
	border-radius: 50%;
	border: 2px solid #ffffff;
	right: 8px;
}

.filemanager .search:after {
	content: '';
	width: 3px;
	height: 10px;
	background-color: #ffffff;
	border-radius: 2px;
	position: absolute;
	top: 23px;
	right: 6px;
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
}

.filemanager .search input[type=search] {
	border-radius: 2px;
	color: #4D535E;
	background-color: #FFF;
	width: 250px;
	height: 44px;
	margin-left: -215px;
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
