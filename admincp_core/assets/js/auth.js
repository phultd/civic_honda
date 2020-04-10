// Loader
try {
	window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    require('bootstrap');
	require('./mdb/buttons.js');
	require('./mdb/cards.js');
	require('./mdb/collapsible.js');
	require('./mdb/character-counter.js');
	require('./mdb/chips.js');
	require('./mdb/dropdown.js');
	require('./mdb/file-input.js');
	require('./mdb/forms-free.js');
	require('./mdb/jquery.easing.js');
	require('./mdb/material-select.js');
	require('./mdb/mdb-autocomplete.js');
	require('./mdb/preloading.js');
	require('./mdb/range-input.js');
	require('./mdb/scrolling-navbar.js');
	require('./mdb/sidenav.js');
	require('./mdb/smooth-scroll.js');
	require('./mdb/sticky.js');
	require('./mdb/treeview.js');
	require('./mdb/waves.js');
	require('./mdb/wow.js');
} catch (e) {}

// jQuery ready code
$(function(){
	$('.mdb-select').materialSelect();
});
