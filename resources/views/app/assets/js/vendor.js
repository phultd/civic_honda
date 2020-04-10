window.$ = window.jQuery = require("jquery");
require('./vendor/flickity/dist/flickity.pkgd.js');
require('flickity-bg-lazyload');

console.log('hello vendor');
import jqueryMousewheel from 'jquery-mousewheel';
jQuery.fn.load = function(callback){ $(window).on("load", callback) };