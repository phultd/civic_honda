export default class Footer {
    constructor() {
        this.goToTop();
    }
   
    goToTop () {
        $('.footer .go-to-top').click(function() {
            $('.wrapper').stop().animate({
                scrollTop: $('.wrapper').offset().top
            }, 2000);
            myApp['changeSnapIndex']('0');
        });
    }
}
