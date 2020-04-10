export default class tabs {
    constructor() {
        this.init();
        this.controller();
    }
    init() {
        var $tabs = $('.tabs');
        // $tabs.each(function() {
        //
        //     var $navItem = $(this).find('.tabs__nav a');
        //     var $ContentItem = $(this).find('.tabs__content__item');
        //     if ( $navItem.find('.active').length === 0) {
        //         $navItem.eq(0).addClass('active');
        //     }
        //     if ( $ContentItem.find('.active').length === 0) {
        //         $ContentItem.eq(0).addClass('active');
        //     }
        //
        // })
    }
    controller() {
        var $navItem = $('.js-tab-list li');
        $navItem.click(function(event) {
           //console.log(1);
            var _index = $(this).attr('data-tab');
            //console.log(_index);
            var parent = $(this).closest('.tab-pane');
            parent.find('.js-tab-list li').removeClass('active');
            parent.find('.js-tab-list li').eq(_index - 1).addClass('active animation-text no-delay');

            parent.find('.js-tab-stage').removeClass('active animation-text no-delay');
            parent.find('.js-tab-stage'+_index).addClass('active animation-text no-delay');
        });
    }
    changeTab(tabs, id) {

        let tabNavSelected = tabs.find('.tabs__nav a[href="'+id+'"]');

        if(tabNavSelected.parent().prop("tagName") == 'LI') {
            tabNavSelected.parent().addClass('active').siblings().removeClass('active no-delay animation-text');
        } else {
            tabNavSelected.addClass('active').siblings().removeClass('active no-delay animation-text');
        }

        tabs.find(id).fadeIn().css("display","block").siblings().hide();

        // $('.flickity-enabled').flickity('resize');
        // $('.flickity-enabled').flickity('reposition')

    }

};
