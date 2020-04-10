import Flickity from 'flickity';
require('../../vendor/flickity/flickity-fade.js');
// import '../../vendor/spin360/3deye.min';
import * as SpriteSpin from "spritespin";
export default class ColorCar {
    constructor() {
        this.init();
    }
    init() {
        var elem             = document.querySelector('.color-carousel');
        var spriteApiObjects = {};
        var flickityIndex    = 2;
        var flkty            = new Flickity( elem, {
            wrapAround: true,
            draggable: false,
            fade: true,
            initialIndex : 2,
            on : {
                ready : () => {
                    setTimeout(() => {
                        flkty.resize();
                    }, 500);
                }
            }
        });

        flkty.on('change', (index) => {
            //console.log(flickityIndex);
            applyFrameIndexToAnother(flickityIndex);
            flickityIndex = index;
        });
        
        function applyFrameIndexToAnother(index) {
            const frame = spriteApiObjects[index].data.frame;

            if (!frame) {
                return;
            }

            Object.keys(spriteApiObjects).map((key) => {
                if (Number(key) !== Number(index)) {
                    spriteApiObjects[key].updateFrame(frame);
                }
            });
        }
        
        
        $('.spritespin-canvas').each(function(index, el) {
            let _name =  $(this).attr('data-name');
            var element = $(`#mySpriteSpin${index + 1}`);
            var api;

            element.spritespin({
                source: SpriteSpin.sourceArray(assets_url+'/images/s-color/'+ _name +'/F{frame}.jpg', {
                     frame: [3,38],
                     digits: 1
                }),
                preloadCount : 36,
                animate: false,
                sense: -1
                // reverse : false
               
            });

            spriteApiObjects[index] = element.spritespin("api");
        });
    }

};
