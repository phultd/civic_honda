export default class fullVertical {
    constructor() {
        this.scrollVertical();
    }
    scrollVertical() {
        var wheel ;
        //console.log(1);
        var currentIndex = 0;
        var target;
        var lockScroll = false;
        var scrollEvent = function(e) {
            if (wheel = e.deltaY != undefined) {
                wheel = e.deltaY
            }
            var scrollDirection = wheel  < 0 ? 'to-top' : 'to-bottom';
            console.log(lockScroll);
            if (scrollDirection == "to-bottom") {
                if(lockScroll === false) {
                    lockScroll = true;
                    currentIndex++;
                    target = $('.js-snap-item').eq(currentIndex);
                    $('html, body').animate({
                         scrollTop:parseInt($(target).offset().top)
                    }, function() {
                        lockScroll = false;
                    });
                    // $('html,body').animate({
                    //     scrollTop:parseInt($(target).offset().top)
                    // }, function() {
                    //     lockScroll = false;
                    // },1000);
                }
            } else {
                if(lockScroll === false) {
                    lockScroll = true;
                    currentIndex--;
                    target = $('.js-snap-item').eq(currentIndex);
                    $('html,body').animate({
                        scrollTop:parseInt($(target).offset().top)
                    }, function() {
                        lockScroll = false;
                    });
                }
            }
        }
        var _w;
        $(window).on('resize', function(){
            _w = $( window ).width();
            if (_w > 1199) {
                window.scrollTo($('#main').offset().top,0);
                $('body').css('overflow', 'hidden');
                window.addEventListener('wheel', scrollEvent, false);
                window.addEventListener('DOMmousewheel', scrollEvent, false);
            }
            else {
                $('body').css('overflow', 'auto');
                $('#main').stop().removeClass('toBottom toTop');
                window.removeEventListener('wheel', scrollEvent, false);
                window.removeEventListener('scroll', scrollEvent, false);
            }
        });
        $(window).trigger("resize");
    }
};
