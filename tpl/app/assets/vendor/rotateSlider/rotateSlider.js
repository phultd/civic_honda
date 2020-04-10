//import TweenMax from '../gsap/TweenMax';
require('../../vendor/gsap/gsap.min.js');
/*
 * No description for old men hehe
 *
 */

(function($) {
    $.fn.rotateSlider = function(opt) {
        var $this = this,
            itemClass = opt.itemClass || 'rotateslider-item',
            arrowClass = opt.arrowClass || 'js-rotateslider-arrow',
            $item = $this.find('.' + itemClass),
            $arrow = $this.find('.' + arrowClass),
            itemCount = $item.length,
            $navigator = $this.find('.js-rotateslider-paginator');


        var defaultIndex = 0;
        var isAnimating = false;

        generatePaginatorItems();
        changeIndex(defaultIndex);

        $arrow.on('click', function() {
            if(isAnimating == false){
                isAnimating = true;
                var action = $(this).data('action'),
                    nowIndex = $item.index($this.find('.now'));

                if(action == 'next') {
                    if(nowIndex == itemCount - 1) {
                        changeIndex(0, 'next');
                    } else {
                        changeIndex(nowIndex + 1, 'next');
                    }
                } else if (action == 'prev') {
                    if(nowIndex == 0) {
                        changeIndex(itemCount - 1, 'prev');
                    } else {
                        changeIndex(nowIndex - 1, 'prev');
                    }
                }
                setTimeout(function(){
                    isAnimating = false;
                }, 300)
            }
        });

        $navigator.find('li').unbind('click').on('click', function () {
            const index = $(this).data('index');
            changeIndex(index);
        });

        function changeIndex (nowIndex, move) {
            // clern all class
            $this.find('.now').removeClass('now');
            $this.find('.next').removeClass('next');
            $this.find('.prev').removeClass('prev');

            if(nowIndex == itemCount -1){
                $item.eq(0).addClass('next');
            }
            if(nowIndex == 0) {
                $item.eq(itemCount -1).addClass('prev');
            }

            $item.each(function(index) {
                if(index == nowIndex) {
                    $item.eq(index).addClass('now');
                    gsap.to($this.find('.now').find('h4'), 0.25, {opacity: 1, bottom: 10});
                }
                if(index == nowIndex + 1 ) {
                    $item.eq(index).addClass('next');

                }
                if(index == nowIndex - 1 ) {
                    $item.eq(index).addClass('prev');
                }
                if(move == 'next'){
                    var prev = $this.find('.prev').find('h4');

                    gsap.to(prev, 0.25, {opacity: 0, bottom: 50, onComplete: function(){
                       setTimeout(function(){
                           gsap.to(prev, 0, {bottom: -50});
                       }, 250)
                    }})
                } else {
                    var next = $this.find('.next').find('h4');
                    gsap.to(next, 0.25, {opacity: 0, bottom: 50, onComplete: function(){
                        setTimeout(function(){
                            gsap.to(next, 0, {bottom: -50});
                        }, 250)
                    }});
                }
            });

            $navigator.find('li').removeClass('active');
            $navigator.find('li').eq(nowIndex).addClass('active');
        }

        function generatePaginatorItems () {
            for (let i = 0; i < itemCount; i++) {
                $navigator.append(`
                    <li class="rotateslider-paginator__item" data-index="${i}"></li>
                `);
            }
        }
    };
})(jQuery);