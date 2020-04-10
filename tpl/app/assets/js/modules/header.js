export default class header {
    constructor() {
        this.hbg = '.header__hbg-button';
        this.extraBtn = '.header__extra-button';
        this.menu = '.header__menu';
        this.extraContent = '.header__honda-tools';
        this.mobile();
        //this.animationMenu();
    }
    mobile() {
        const hbg = $(this.hbg);
        const extraBtn = $(this.extraBtn);
        hbg.on("click", (e) => {
            const _this = $(e.currentTarget);
            if(_this.hasClass('open')) {
                this.closeMenu(this.hbg, this.menu);
                $(this.menu).find('.main-menu').removeClass('animation-li');
            } else {
                this.openMenu(this.hbg, this.menu);
                $(this.menu).find('.main-menu').addClass('animation-li');
            }
        })
        extraBtn.on("click", (e) => {
            const _this = $(e.currentTarget);
            if(_this.hasClass('open')) {
                this.closeMenu(this.extraBtn, this.extraContent);
            } else {
                this.openMenu(this.extraBtn, this.extraContent);
            }
        });

        var _w = $(window).innerWidth();
        var self = this;
        
        $(window).on('load', function() {
            if (_w < 992) {
                setTimeout(function(){
                     $('.main-menu').removeClass('animation-li');
                }, 300);
            }
        });
        $( window ).resize(function() {
            _w = $(window).innerWidth();
            if (_w < 992) {
                setTimeout(function(){
                     $('.main-menu').removeClass('animation-li');
                }, 300);
                $('.main-menu li a').on("click", (e) => {
                    self.closeMenu(self.hbg, self.menu);
                });
            }
        });
        $(window).trigger( "resize" );
    }
    openMenu(btn,content) {
       // console.log('open');
        const menu = $(content);
        const hbg = $(btn);
        $(".popup").hide();
        menu.addClass("open");
        hbg.addClass("open");
        // lock scroll
        $("html, body").addClass("popup-active").css({
            "overflow": "hidden"
        })



        //IOS bug
        //if ( device.ios()) {
        var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
        //console.log(iOS);
        if (iOS == true) {
            var currentTopY = $(window).scrollTop();
            $("body").addClass("body-fixed").attr('last-posY', currentTopY);
            $("body").css('top', -currentTopY);
        }
    }

    closeMenu(btn,content) {
        //console.log('close');
        const menu = $(content);
        const hbg = $(btn);

        menu.removeClass("open");
        hbg.removeClass("open");

        $("html, body").removeClass("popup-active").removeAttr("style");

        //if ( device.ios()) {
        var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
        if (iOS == true) {
            var currentTopY = $('body').attr('last-posY');
            $("body").removeClass("body-fixed").removeAttr('style');
            $(window).scrollTop(currentTopY);
        }
    }
    animationMenu () {
        // $('#popup_enter').click(function(event) {
        //     console.log(1);
        //     $('.main-menu').addClass('animation-li');
        // });
    }
}
