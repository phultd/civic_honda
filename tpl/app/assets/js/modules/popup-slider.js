import '../../vendor/rotateSlider/rotateSlider';

export default class popupSlider {
    constructor() {
        this.init();
    }
    init() {
        $('.slider__rotate').each(function () {
        	//$(this).rotateSlider({});
        	var _item = $(this).find('.rotateslider-item');
        	if(_item.length > 2){
	            //$('.rotateslider-container').each(function(){
	                $(this).rotateSlider({});
                    $(this).closest('.popup').css('overflow', 'hidden');
	           // })
	        }
	        else {
	            _item.addClass('rotateslider-item--inline');
	            $(this).find('.o-arrow').hide();
	            $(this).find('.rotateslider-container').css('min-height', 'auto');

	        }
        });

        //$('.slider__rotate2').rotateSlider({});
    }

};
