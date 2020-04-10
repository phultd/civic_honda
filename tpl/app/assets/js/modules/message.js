import ScrollMagic from 'scrollmagic';

export default class Message {
    constructor() {
        this.init(); 
    }
    init() {
        var controller = new ScrollMagic.Controller();
        new ScrollMagic.Scene({
            triggerElement : ".car-holder",
            offset: 30,
            triggerHook : 0.7,
            reverse : true,
            duration: "100%"
        })
        .on('enter', (e) => {
            $('.s-message').addClass('active');
            //let _flare = $('.s-message .flare');
            //TweenMax.staggerFromTo(_flare, 0.1, { scale: 0.7, opacity:0}, { scale: 1, opacity:1, ease: Power2.easeOut}, 0.1)
        })
        .on('leave', (e) => {
            $('.s-message').removeClass('active');
            //let _flare = $('.s-message .flare');
            //TweenMax.staggerFromTo(_flare, 0.1, { scale: 0.7, opacity:0}, { scale: 1, opacity:1, ease: Power2.easeOut}, 0.1)
        })
        .addTo(controller); 
    }


};
