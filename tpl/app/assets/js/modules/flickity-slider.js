import Flickity from 'flickity';
require('../../vendor/flickity/flickity-fade.js');
export default class FlickitySlider {
    constructor() {
        this.init();
    }
    init() {
        var elem = document.querySelector('.main-carousel');
        var flkty = new Flickity( elem, {
            //freeScroll: true,
            wrapAround: true,
            fade: true,
            draggable: false,
            on : {
                ready : () => {
                    setTimeout(() => {
                        flkty.resize();
                    }, 500);
                }
            }
        });
        flkty.resize();
    }

};
