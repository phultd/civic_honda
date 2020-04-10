import ScrollMagic from 'scrollmagic';
//import '../../vendor/gsap/TimelineLite.js';
export default class Animation {
    constructor() {
         this.scrollMagic()
    }
    scrollMagic() {
        var controller = new ScrollMagic.Controller();
        new ScrollMagic.Scene({
            triggerElement : ".s-message",
            triggerHook : 0.7,
            reverse: false,
            offset : 300,
            duration: "50%"
        })
        // .setTween(tl)
        .on('enter', (e) => {
            //var _img = $('.s-intro h2 img');
            let _title = $('.s-message .section-block__title');
            let _desc = $('.s-message .section-block__desc');
            //TweenMax.staggerFromTo(_img, 0.75, { y: -200, opacity:0}, { y:0, opacity:1, ease: Power2.easeOut}, 0.1)
            TweenMax.staggerFromTo(_title, 0.75, { y: -200, opacity:0}, { y:0, opacity:1, ease: Power2.easeOut}, 0.2)
            TweenMax.staggerFromTo(_desc, 0.75, { y: 200, opacity:0}, { y:0, opacity:1, ease: Power2.easeOut}, 0.3)
        })
        .addTo(controller);
        new ScrollMagic.Scene({
            triggerElement : ".header",
            triggerHook : 0.7,
            reverse: false,
            duration: "50%"
        })
        // .setTween(tl)
        .on('enter', (e) => {
            var _menu = $('.header .main-menu li');
            _menu.each(function( index ) {
                //console.log(_menu.eq(index));
                //TweenMax.staggerFromTo(_menu.eq(index), 0.75, { y: -100, opacity:0}, { y:0, opacity:1, ease: Power2.easeOut}, index*0.1)
            });
        })
        .addTo(controller); // assign the scene to the controller
        $('.tab-pane').each((index,ele)=> {
            new ScrollMagic.Scene({
                triggerElement : ele,
                triggerHook : 0.7,
                reverse: false,
                duration: "50%"
            })
            // .setTween(tl)
            .on('enter', (e) => {
                let _tablist = $(ele).find('.list-tabs li');
                let _title = $(ele).find('.tab-pane__content__title');
                let _desc = $(ele).find('.tab-pane__content__desc');
                // tl.to(_tablist, 2, {x: 200 , opacity:0})
                //   .to(_title, 1, {x: 200, opacity:0 })
                //   .to(_desc, 1, {x: 200, opacity:0});
                $(ele).find('.tab-pane__content .tab-pane__item').eq(0).addClass('animation-text');
                TweenMax.staggerFromTo(_tablist, 0.75, { x: 200, opacity:0}, { x:0, opacity:1, ease: Power2.easeOut}, 0.1)
                //TweenMax.staggerFromTo(_title, 0.75, { x: 200, opacity:0}, { x:0, opacity:1, ease: Power2.easeOut}, 3000)
                //TweenMax.staggerFromTo(_desc, 0.75, { x: 200, opacity:0}, { x:0, opacity:1, ease: Power2.easeOut}, 6000)
            })
            .addTo(controller);
        });
   }

};
