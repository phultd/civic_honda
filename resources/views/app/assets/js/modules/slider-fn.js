/**
 * Created by CLIMAX PRODUCTION on 4/12/2019.
 */
import Flickity from '../../vendor/flickity/flickity.pkgd.min';
export default class SliderFn{
    constructor(){
        this.jsDots = '.js-set-dots';
        this.circleCarousel = '';
        this.init();
    }
    init(){
        this.circlesSlide();
        setTimeout(() => {
            for(let i = 0 ; i < $(this.jsDots).length; i++){
                var _this = $(this.jsDots)[i];
                this.setDots(_this);
            }
        }, 200);
    }
    setDots(wrapper){
        var dots = '.flickity-page-dots';
        var elmDots = $(wrapper).find(dots);
        if(elmDots.length === 0) return false;
        var list_dot = $(elmDots).find('.dot');
        var data_dots = $(wrapper).attr('data-dots');
        data_dots = JSON.parse(data_dots);
        for(let i = 0; i < data_dots.length; i++){
            var item = data_dots[i];
            var src_inactive = item['inactive'];
            var src_active = item['active'];
            if(src_inactive.length !== 0){
                var dot_inactive = this.makeIcoDot(src_inactive, false);
                list_dot[i].appendChild(dot_inactive);
            }
            if(src_active.length !== 0){
                var dot_active = this.makeIcoDot(src_active, true);
                list_dot[i].appendChild(dot_active);
            }
        }
        $(wrapper).removeAttr('data-dots');
    }
    makeIcoDot(src, isActive){
        var dot = document.createElement('span');
        var classList = isActive ? "ico-dot-active" : "ico-dot";
        dot.classList.add(classList);
        dot.style.background = "url("+src+") no-repeat center";
        return dot;
    }
    circlesSlide(){
        var selector = '.js-circles-slide';
        var selector_item = '.js-circle-item';
        if($(selector).length === 0) return false;
        var items = $(selector_item);
        var indexItemSelect = 0;
        if(items.length > 2){
            indexItemSelect = Math.floor(items.length/2);
        }
        this.circleCarousel = new Flickity(selector, {
            "imagesLoaded": true,
            "draggable": true,
            "prevNextButtons": false,
            "pageDots": false,
            "initialIndex" : indexItemSelect,
            on : {
                ready : () => {
                    setTimeout(() => {
                        this.circleCarousel.reposition();
                        this.hiddenOutRange(selector, selector_item, indexItemSelect);
                    }, 500);
                }
            }
        });
        this.circleCarousel.on('change', (index) => {
            var selector = '.js-circles-slide';
            var selector_item = '.js-circle-item';
            this.circleCarousel.reposition();
            this.hiddenOutRange(selector, selector_item, index);
        });
        this.circleCarousel.on('staticClick', (event, pointer, cellElm, cellIndex) => {
            this.circleCarousel.select(cellIndex);
        })
    }
    hiddenOutRange(wrapper, items, index){
        var w_wrapper = $(wrapper).width();
        var w_is_selected = $(items + '.is-selected').outerWidth();
        var w_default = $(items).outerWidth();
        var items = $(items);
        var w_in_range = w_is_selected;
        var total_in_range = 1;
        for( let i = 0; i< items.length; i++){
            if(w_wrapper <= w_in_range + w_default/2) break;
            total_in_range += 1;
            w_in_range += $(items[i]).outerWidth();
        }
        var each_side = Math.floor((total_in_range - 1)/2);
        var left = [];
        var right = [];
        /*left side*/
        for(let i = 1 ; i <= each_side; i++){
            var index_left = index - i;
            if(index_left < 0) break;
            left.push($(items[index_left]));
        }
        /*right side*/
        for(let i = 1 ; i <= each_side; i++){
            var index_left = index + i;
            if($(items[index_left]).length === 0) break;
            right.push($(items[index_left]));
        }
        var ar_result = left.concat(right);
        /*visible*/
        items.removeClass('visible-item');
        for(let i = 0 ; i < ar_result.length; i++){
            var elm = $(ar_result[i]);
            elm.addClass('visible-item');
        }
    }
}