import lozad from 'lozad';
export default class lazyload {
    constructor(){
        this.init();
        myApp['reInitLozad'] = this.init.bind(this);
    }
    init(){
        const observer = lozad('.lozad', {
            loaded: function(el) {
                if($(el).attr('data-background-image')) {
                    el.classList.add('loaded');
                }
                el.onload = function() {
                    el.classList.add('loaded');
                }
            }
        });
        observer.observe();
    }
}
