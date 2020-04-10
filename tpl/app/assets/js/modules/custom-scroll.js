import jqueryMousewheel from 'jquery-mousewheel';
import mCustomScrollbar from 'malihu-custom-scrollbar-plugin';

export default class customScroll {
    constructor() {
        this.target = '.js-custom-scroll';
        this.init();
    }
    init() {
        $(this.target).mCustomScrollbar();
    }
    getData(dataResult) {
    }

    initEvents() {
    }
};
