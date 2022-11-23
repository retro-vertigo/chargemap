import SmoothScroll from "./SmoothScroll";

export default class Anchors {

    constructor(el) {
        if(el) {
            this.el       = el;
            this.tabList = this.el.querySelector('.tablist');
            this.btnsTabs = this.el.querySelectorAll('.tablist__btn');
            
            this.init();
        }
    }

    init() {
        this.btnsTabs.forEach(  el => {
            el.addEventListener('click', e => this.clickTab(e) );
        });
    }

    clickTab(e) {
        e.preventDefault();
        let offset = - this.tabList.offsetHeight -10;
        SmoothScroll.scrollToTarget(document.querySelector(e.currentTarget.hash), 900, 'easeInOutCubic', offset);
    }
}

