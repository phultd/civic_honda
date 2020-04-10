require('../../vendor/gsap/gsap.min.js');

export default class navigator {
    constructor() {
        this.scrolling = false;
        this.wrapper = '.snap-scroll';
        this.item = '.js-navigator-item';
        this.line = '.header__menu__line';
        this.init();
        this.hashURL();
        this.controller();
        this.scrollActive();
    }
    init() {
        $(this.item).each(function(i,ele) {
            $(this).attr('data-nav-index',i)
        })
    }
    controller() {
        const $menu = $('.main-menu li a');
        let target;
        let timeout;
        $menu.click((e) => {
            target = $(e.currentTarget).attr('href');
            //console.log(target);
            this.activeMenu(target);
            this.scrolling = true;
            clearTimeout(timeout);
            myApp['changeSnapIndex']($(target).attr('data-snap-index'));
            timeout = setTimeout((e)=> {
                this.scrolling = false;
                myApp['changeSnapIndex']($(target).attr('data-snap-index'));
            },1000);
            e.preventDefault();
            //return false
        })
    }
    activeMenu(targetID) {
        const $menu = $('.main-menu');
        $menu.find(`a[href="${targetID}"]`).parent().addClass('active').siblings().removeClass('active');
        $(this.wrapper).animate({
            scrollTop: $(this.wrapper).scrollTop() + $(targetID).offset().top
        },1000);

        if(window.innerWidth < 1200) {
            const menu = $('.header__menu');
            const hbg = $('.header__hbg-button');

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
    }
    scrollActive() {
        var ele = $(this.item);
        // console.log(ele)
        var windownHeight = window.innerHeight;
        var oldSecionID = "";


        $.fn.textWidth = function(){
            var html_org = $(this).html();
            var html_calc = '<span>' + html_org + '</span>';
            $(this).html(html_calc);
            var width = $(this).find('span:first').width();
            $(this).html(html_org);
            return width;
        };


        $(this.wrapper).scroll((e) => {
            if(this.scrolling !== true) {
                var scrollTop = $(this.wrapper).scrollTop();
                //console.log(scrollTop);
                var sectionID;
                ele.each((index, ele)=> {
                    var eleTop = ($(this.wrapper).scrollTop() + $(ele).offset().top) - windownHeight * 0.3;
                    if (eleTop < scrollTop) {
                        if($(ele).attr("id")) {
                            sectionID = $(ele).attr("id");
                        }  else {
                            sectionID = $(ele).children('section').eq(0).attr("id");
                        }
                    }
                    //console.log(sectionID);
                })

                //console.log(sectionID);
                setTimeout((e)=>{
                    if(oldSecionID != sectionID) {
                        window.history.pushState('', '', '#' + sectionID);
                        oldSecionID = sectionID;
                    }
                },0)
                var target = $('.main-menu a[href="#' + sectionID + '"]');
                if (target.length > 0) {
                    $('.main-menu a[href="#' + sectionID + '"]').parent().addClass("active").siblings().removeClass("active");

                    var x = target.offset().left + (target.width() - target.textWidth())/2 - $('.header__menu').offset().left;
                    var w = target.textWidth();
                    this.menuLineMove(x,w,1);

                } else {
                    $('.main-menu li').removeClass("active");

                    this.menuLineMove(x,w,0);
                }


            }
        })
    }
    scrollToDiv(target) {
        $(this.wrapper).stop().animate({
            scrollTop: $(target).offset().top - 75
        }, 1000);
    }
    hashURL() {
        if(window.location.hash && window.innerWidth < 1200) {
            // setTimeout(function() {
            //     window.scrollTo(0, 0);
            //   }, 1);
            let timeout;
            this.scrolling = true;
            clearTimeout(timeout);
            timeout = setTimeout((e)=> {
                this.scrolling = false;
            },600);
            window.addEventListener('load',(e)=>{
                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                setTimeout((e) => {
                    this.scrollToDiv('#'+hash);
                },2)
            })
        }
    }
    menuLineMove(x,w,opacity) {
        const line = $(this.line);
        gsap.to(line, {x:x, width:w, duration:0.5, opacity: opacity,ease: "power2.out"})
    }
}
