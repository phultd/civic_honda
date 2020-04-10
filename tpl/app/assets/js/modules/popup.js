import '../../vendor/rotateSlider/rotateSlider';
export default class popup {
    constructor() {
        this.action();
        myApp['openPopup'] = this.openPopup.bind(this);
        myApp['closePopup'] = this.closePopup.bind(this);
    }
    openPopup(popupID) {
        //console.log(popupID);

        var popupBox = $(popupID).find(".popup__content");
        var popupClose = $(popupID).find(".popup__close");
        var popupChild = $(popupID).find(".popup__content > *");
        var bodyWrap = $(".wrapper");

        //console.log($(popupID));

        $(".popup").hide();
        $(popupID).fadeIn(200).addClass("open");

        // add padding on desktop
        var viewport = $(window).width();
        var viewportInner = window.innerWidth;
        if (viewport < viewportInner) {
            $("html").css({
                "padding-right": 17
            });
            $('.header').css({
                "width" : "calc(100% - 17px)"
            });
            $('.honda-tools').css({
                "opacity" : "0"
            })
        }

        // lock scroll
        $("html, body").addClass("popup-active").css({
            "overflow": "hidden"
        })

        // Change URL
        if ($(popupID).attr("data-url")) {
            var url = $(popupID).data('url');
            window.history.pushState({
                urlPath: ''
            }, "", url);
        }

        //IOS bug
        //if ( device.ios()) {
        var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
        //console.log(iOS);
        if (iOS == true) {
            var currentTopY = $(window).scrollTop();
            $("body").addClass("body-fixed").attr('last-posY', currentTopY);
            $("body").css('top', -currentTopY);

        }
        if ($('.popup .flickity-enabled').length > 1) {
            $('.popup .flickity-enabled').flickity('resize');
        }
        
        // $('.popup .flickity-enabled').flickity('reposition')
        // window resize to fix sliock slider
        // setTimeout(function() {
        //   $(window).resize();
        // }, 0)
    }

    closePopup(popupID) {
        //console.log(2);

        var popupBox = $(popupID).find(".popup__content");
        var popupClose = $(popupID).find(".popup__close");
        var bodyWrap = $(".wrapper");

        $(popupID).fadeOut(300).removeClass("open");;

        // remove padding on desktop
        setTimeout(function() {
            $("html, body").removeClass("popup-active").removeAttr("style");
            $('.header').removeAttr("style");
            $('.honda-tools').removeAttr("style");
        }, 300)

        // Remove URL
        if ($(popupID).attr("data-url")) {
            var url = $(popupID).data('url');
            window.history.pushState({
                urlPath: ''
            }, "", ' ');
        }

        //if ( device.ios()) {
        var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
        if (iOS == true) {
            var currentTopY = $('body').attr('last-posY');
            $("body").removeClass("body-fixed").removeAttr('style');
            $(window).scrollTop(currentTopY);
        }

    }

    action() {
        //Close btn popup
        $(document).on('click', '.popup__close, .js-popup-close', (e) => {
            let _this = e.currentTarget;
            var popupID = "#" + $(_this).parents(".popup").attr("id");
            this.closePopup(popupID);
            e.preventDefault();
        })


        $(".popup").click((e) => {
            let _this = e.currentTarget;
            if ($(e.target).closest('.popup__container').length === 0) {
                /**/
                if($(_this).hasClass('disable-outside-close')){
                    return false;
                }
                /**/
                var popupID = '#' + $(e.target).closest('.popup').attr("id");
                this.closePopup(popupID);
                myApp['pauseAllVideo']();
            }
        });

        //Open btn popup
        $(document).on('click', '.js-popup-open', (e) => {
            let _this = e.currentTarget;
            var popupID = $(_this).attr("href");
            this.openPopup(popupID);

            // active part
            if($(_this).hasClass('js-active-part')) {
                this.activePart(popupID, $(_this).closest('.parts-gallery__item ').index())
            }

            //preventDefault
            e.preventDefault();
        })
    }
    activePart(id, index) {
        $(id).find('.popup-parts__carousel').flickity('select', index, false, true);
    }
}
