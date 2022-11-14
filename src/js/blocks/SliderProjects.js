// *** import if no add-ons needed
import Flickity from '../vendors/flickity.pkgd.min.js'


export default class SliderProjects {

    constructor(el) {
        this.block    = el;
        this.slider   = this.block.querySelector('.slider-projects');
        this.btnPrev  = this.block.querySelector('.btn-flickity.--prev');
        this.btnNext  = this.block.querySelector('.btn-flickity.--next');

        this.init();
    }

    init () {
        // prevent FOUC on load
        this.slider.offsetHeight;      // trigger redraw for transition

        // ***** options *****
        let options = {
            prevNextButtons: false,
            pageDots: false,
            contain: true,
            watchCSS: true,
            wrapAround: true,
            freeScroll: true
        }
        this.flkty = new Flickity(this.slider, options);

        // ***** API *****
        // custom prev / next button
        this.initControls();

        // PATCH iOS 15 horizontal drag bug
        // https://github.com/metafizzy/flickity/issues/1177
        this.flkty.on('dragStart', () => (document.ontouchmove = () => false));
        this.flkty.on('dragEnd', () => (document.ontouchmove = () => true));
    }


    // Custom controls
    // -----------------------------------------------

    // set custom prev / next buttons
    initControls() {
        this.btnPrev.addEventListener('click', e => {
            this.flkty.previous();
        });
        this.btnNext.addEventListener('click', e => {
            this.flkty.next();
        });
    }
}
