import jqueryMousewheel from 'jquery-mousewheel';
import mCustomScrollbar from 'malihu-custom-scrollbar-plugin';

export default class customScroll {
    constructor() {
        this.selector = ".js-custom-scroll";
        this.initEvents();
    }
    initEvents() {
        $(this.selector).mCustomScrollbar();
    }
};