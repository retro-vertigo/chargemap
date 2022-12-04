import Flickity from 'flickity-imagesloaded';

export default class SliderReplay {

    constructor(el) {
        this.block    = el;
        this.slider   = this.block.querySelector('.slider-cards-webinar');
        this.btnPrev  = this.block.querySelector('.btn-flickity.--prev');
        this.btnNext  = this.block.querySelector('.btn-flickity.--next');
        this.btnNext  = this.block.querySelector('.btn-flickity.--next');
        this.controls  = this.block.querySelector('.slider-flickity-controls');

        this.init();
    }

    init () {
        // prevent FOUC on load
        this.slider.offsetHeight;      // trigger redraw for transition

        // ***** options *****
        let options = {
            prevNextButtons: false,
            pageDots: false,
            imagesLoaded: true,
            watchCSS: true,
            cellAlign: 'left',
            groupCells: true,    // if set to true group cells that fit in carousel viewport
            contain: true,
        }
        this.flkty = new Flickity(this.slider, options);
        
        // ***** API *****
        this.flkty.on( 'change', ( index ) => {
            this.onChange(index);
        });

        // custom prev / next button
        if(this.btnPrev) this.initControls();

        if(this.flkty.slides && this.flkty.slides.length > 1) {
            this.updateControls();
        } else {
            if(this.controls) {
                this.controls.style.display = "none";
                this.btnPrev.style.display = "none";
                this.btnNext.style.display = "none";
            }
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
