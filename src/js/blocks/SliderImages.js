// *** import if no add-ons needed
// import Flickity from '../vendors/flickity.pkgd.min.js'
// import 'flickity-imagesloaded.js'
import Flickity from 'flickity-imagesloaded';
// import 'flickity-imagesloaded';

// *** import if add-ons with npm packages
// import Flickity from 'flickity-fade'
// import 'flickity-hash'

// *** import if add-ons with paths
// import Flickity from '../vendors/flickity-fade.js'
// import '../vendors/flickity-hash.js'

export default class SliderImages {

    constructor(el) {
        this.block    = el;
        this.slider   = this.block.querySelector('.slider-images');
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
            pageDots: true,
            // setGallerySize: true,
            imagesLoaded: true,
            watchCSS: true,
        }
        this.flkty = new Flickity(this.slider, options);
        
        // ***** API *****
        // Select slide on click
        this.flkty.on( 'staticClick', ( event, pointer, cellElement, cellIndex ) => {
            if ( typeof cellIndex == 'number' && cellIndex != this.flkty.selectedIndex) {
              this.flkty.selectCell( cellIndex );
            }
        });

        this.flkty.on( 'change', ( index ) => {
            this.onChange(index);
        });

        // custom prev / next button
        if(this.btnPrev) this.initControls();
        
        if(this.flkty.slides && this.flkty.slides.length > 1) {
            this.updateControls();
        }

        // PATCH iOS 15 horizontal drag bug
        // https://github.com/metafizzy/flickity/issues/1177
        this.flkty.on('dragStart', () => (document.ontouchmove = () => false));
        this.flkty.on('dragEnd', () => (document.ontouchmove = () => true));
    }



    // Events 
    // -----------------------------------------------

    onChange(index) {
        this.updateControls();
    }


    // Custom controls
    // -----------------------------------------------

    // set custom prev / next buttons
    initControls() {
        this.btnPrev.addEventListener('click', e => {
            if(this.flkty.selectedIndex > 0) this.flkty.previous();
        });
        this.btnNext.addEventListener('click', e => {
            if(this.flkty.selectedIndex < this.flkty.slides.length-1) this.flkty.next();
        });
    }

    // disable / enable buttons 
    updateControls() {
        if(this.flkty.selectedIndex == 0) {
            this.btnPrev.setAttribute('disabled', true);
            this.btnNext.removeAttribute('disabled');       // <-- remove disabled from the next
        } else if(this.flkty.selectedIndex == this.flkty.slides.length-1) {
            this.btnNext.setAttribute('disabled', true);
            this.btnPrev.removeAttribute('disabled');       // <-- remove disabled from the prev
        } else {
            this.btnPrev.removeAttribute('disabled');
            this.btnNext.removeAttribute('disabled');
        }
    }
}
