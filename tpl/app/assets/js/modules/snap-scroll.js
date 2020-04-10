require('../../vendor/gsap/gsap.min.js');
require('../../vendor/gsap/ScrollToPlugin.min.js');
export default class SnapScroll {
    constructor() {
        this.snapOn = true;
        this.currentIndex = 0;
        this.sections = [];
        this.lockScroll = false;
        this.wrapper = '.snap-scroll';
        this.classSection = '.js-snap-item';
        this.destroyEle = $('.js-snap-scroll-destroy');
        this.init();
        myApp['changeSnapIndex'] = this.changeSnapIndex.bind(this);
        myApp['scrollTo'] = this.scrollTo.bind(this);
    }
    init() {
        $(this.classSection).each(function(i,ele) {
            $(this).attr('data-snap-index',i)
        });
        if(window.innerWidth > 1199) {
            this.pushSections();
            this.hashURL();
            this.controller();
        }
        //console.log(this.sections);
    }
    controller() {
        var timeout;
        let direct = "down";
        $(this.wrapper).on('wheel', (e)=> {
            //console.log(e.originalEvent.deltaY);
            //console.log(this.currentIndex);
            if(e.originalEvent.deltaY < 0){
                
                direct = "up";
                if(this.lockScroll === false) {
                    this.currentIndex--;
                    this.checkIndex();
                    this.scrollTo(this.sections[this.currentIndex]);
                    this.lockScroll = true;
                }
            } else {
                if(this.lockScroll === false) {
                    //console.log(this.currentIndex);
                    direct = "down";
                    this.currentIndex++;
                    this.checkIndex();
                    this.scrollTo(this.sections[this.currentIndex]);
                    this.lockScroll = true;
                }
            }

            this.specialFrames(this.currentIndex);

        });
    }
    scrollTo(target) {
        gsap.killTweensOf(this.wrapper);
        gsap.to(this.wrapper, {duration: 1, scrollTo:target, ease: "power2.inOut", onComplete:(e)=>{this.lockScroll = false}});

    }
    pushSections() {
        $(this.classSection).each((index,ele)=> {
            this.sections.push("."+ele.classList[0]);
        })
    }
    checkIndex() {
        if (this.currentIndex < 0) {
            this.currentIndex = 0;
        } else if ( this.currentIndex > this.sections.length - 1 ) {
            this.currentIndex = this.sections.length - 1;
        }
    }
    snapOffStage(direct) {
        let _scrollTop = $(this.wrapper).scrollTop();
        const _currentIndex = this.currentIndex;
        const _currentItem = $(this.sections[_currentIndex]);
        const _currentItem_Offsets = $(this.wrapper).scrollTop() + _currentItem.offset().top;
        const _currentItem_Height = _currentItem.outerHeight(true);
        // console.log(direct);
        if(direct == "down") {
            if( _scrollTop > (_currentItem_Offsets +_currentItem_Height - 150)) {
                this.snapOn = true;
                this.lockScroll === false;
                //console.log('d On after');
            }
        } else {
            if( _scrollTop < (_currentItem_Offsets)) {
                this.snapOn = true;
                this.lockScroll === false;
                //console.log('d On after');
            }
        }

        // if( _scrollTop < (_currentItem_Offsets - 160)) {
        //     this.snapOn = true;
        //     this.lockScroll === true;
        //     console.log('before');
        // }
        // //console.log(_scrollTop +' '+(_currentItem_Offsets +_currentItem_Height));
        // if( _scrollTop > (_currentItem_Offsets +_currentItem_Height - 150)) {
        //     this.snapOn = true;
        //     // this.currentIndex++;
        //     // this.checkIndex();
        //     //this.lockScroll === true;
        //     console.log('after');
        // }
    }
    hashURL() {
        if(window.location.hash && window.innerWidth > 1199) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            var classSection =  document.getElementById(hash)
            if(classSection) {
                classSection = classSection.classList[0];
                for (var i = 0; i < this.sections.length; i++) {
                    if(this.sections[i] == '.'+classSection) {
                        this.currentIndex = i;
                        break;
                    }
                }
                window.addEventListener('load',(e)=>{
                    setTimeout((e) => {
                        this.scrollTo('#'+hash);
                    },2)
                })
            }
        }
    }
    changeSnapIndex(index) {
        this.currentIndex = index;
    }
    specialFrames(index) {

        //hide tools
        if(index == 10 || index == 11) {
            $('.honda-tools').addClass('hidding');
        } else {
            $('.honda-tools').removeClass('hidding');
        }

    }
};
