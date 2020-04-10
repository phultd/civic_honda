/**
 * Created by ADMIN on 4/15/2019.
 */
export default class StepSide{
    constructor(){
        this.selector = '.js-side';
        this.side = '.js-side-item';
        this.wrapper = '.step-block';
        this.timeOut = '';
        this.init();
    }
    init(){
        this.eventClick();
    }
    eventClick(){
        var selector = $(this.selector);
        selector.unbind('click').click((e) =>{
            var _this = $(e.currentTarget);
            if($(_this).closest(this.side).hasClass('active'))
            {
                this.hiddenBorder();
                $(_this).closest(this.side).removeClass('active');
                $(this.side).removeClass('inactive');
                $(this.wrapper).removeClass('in-effect');
                return false;
            }
            $(this.side).removeClass('active').addClass('inactive');
            $(_this).closest(this.side).removeClass('inactive').addClass('active');
            $(this.wrapper).addClass('in-effect');
        })
    }
    hiddenBorder(){
        var elm = $(this.side).find('.step-item__desc-icon .icon');
        $(elm).addClass('hidden-border');
        window.clearTimeout(this.timeOut);
        this.timeOut = setTimeout(function(){
            $(elm).removeClass('hidden-border');
        }, 350);
    }
}