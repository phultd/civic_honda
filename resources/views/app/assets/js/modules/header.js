/**
 * Created by ADMIN on 4/17/2019.
 */
export default class Header{
    constructor(){
        this.init();
    }
    init(){
        $('.js-btn-search').click(function(){
            $(this).toggleClass('active');
        });
        var container = $('.js-btn-search');
        $('body').click(function(e){
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                $(container).removeClass('active');
            }
        })
    }
}