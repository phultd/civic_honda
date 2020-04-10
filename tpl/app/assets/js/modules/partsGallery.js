var $ = require('jquery');
var jQueryBridget = require('jquery-bridget');
var Flickity = require('flickity');
require('flickity-imagesloaded');
Flickity.setJQuery( $ );
jQueryBridget( 'flickity', Flickity, $ );

export default class PartsGallery {
    constructor() {
        this.carousel = '.js-parts-carousel';
        this.init();
    }
    init() {
            const carousel = $(this.carousel);
            carousel.each(function() {
                $(this).on( 'ready.flickity', (e)=> {
                    $(e.currentTarget).find('.flickity-prev-next-button.previous').html(`<svg xmlns="http://www.w3.org/2000/svg" width="53.345" height="24.852" viewBox="0 0 53.345 24.852"><g transform="translate(0 0)"><path d="M-187.66,181.732H-232.2l-1.821,1.719,13.164,12.426,2.389-2.391-8.89-8.316h39.7Z" transform="translate(234.021 -171.026)" fill="#fff"/><path d="M-212.84,160.656l-2.389-2.391-8.442,7.969h4.868Z" transform="translate(228.393 -158.265)" fill="#fff"/></g><rect width="3.406" height="3.406" transform="translate(49.939 10.674)" fill="#fff"/></svg>`);
                    $(e.currentTarget).find('.flickity-prev-next-button.next').html(`<svg xmlns="http://www.w3.org/2000/svg" width="53.345" height="24.852" viewBox="0 0 53.345 24.852"><g transform="translate(6.984 0)"><path d="M-234.02,181.732h44.539l1.821,1.719-13.164,12.426-2.389-2.391,8.89-8.316h-39.7Z" transform="translate(234.02 -171.026)" fill="#fff"/><path d="M-223.672,160.656l2.389-2.391,8.442,7.969h-4.868Z" transform="translate(254.48 -158.265)" fill="#fff"/></g><rect width="3.406" height="3.406" transform="translate(0 10.674)" fill="#fff"/></svg>`);
                });
                $(this).flickity({
                    freeScroll: false,
                    contain: true,
                    prevNextButtons: true,
                    pageDots: false,
                    groupCells: true,
                    imagesLoaded: true,
                    arrowShape: 'M38,73.6c1,1,2.7,1,3.7,0c1-1,1-2.6,0-3.6L22.9,51.5h61.9c1.4,0,2.6-1.1,2.6-2.6c0-1.4-1.1-2.6-2.6-2.6H22.9L41.7,28 c1-1,1-2.7,0-3.6c-1-1-2.7-1-3.7,0L14.8,47.1c-1,1-1,2.6,0,3.6L38,73.6z'
                });
            });

            // $(window).on('load', function() {
            //     carousel.flickity('resize');
            //     carousel.flickity('reposition');
            // })
        }
};
