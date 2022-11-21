// *** import if no add-ons needed
import Flickity from '../vendors/flickity.pkgd.min.js'


export default class SliderLogos {

    constructor(el) {
        this.block    = el;
        this.slider   = this.block.querySelector('.slider-logos');

        // current slide / last slide
        this.currentIndex;
        this.lastIndex;
        this.currentSlide;
        this.lastSlide;
        
        // custom autoplay
        this.isPaused      = false;
        this.autoPlay      = true;
        this.tickerSpeed = 1.2;

        // largeur fixe des images
        this.slideWidth = 216;
        this.nbSlides =  this.slider.childElementCount;
        this.slidesTotalWidth =  this.nbSlides * this.slideWidth;

        // ∆∆∆∆∆∆∆∆∆∆∆∆∆
        this.autoPlay      = true;
        // ∆∆∆∆∆∆∆∆∆∆∆∆∆

        if (this.block.classList.contains('is-admin'))  this.autoPlay = false;
        if (window.innerWidth < 576) this.autoPlay = false; 
        if (window.innerWidth >= this.slidesTotalWidth) this.autoPlay = false; 


        console.log(' this.slidesTotalWidth',  this.slidesTotalWidth);
        
        if (window.innerWidth < 576) this.autoPlay = false; 
        
        if (this.slider) this.init();
    }

    init () {
        // prevent FOUC on load
        this.slider.offsetHeight;      // trigger redraw for transition

        // ***** options *****
        let options = {
            // setGallerySize: false,
            selectedAttraction: 0.015,
            friction: 0.25,
            wrapAround: this.autoPlay,
            pageDots: false,
            prevNextButtons: false,
            // cellAlign: 'left',
            // contain: true,
            // freeScroll: true,
            
            // selectedAttraction: 0.01,
            // friction: 0.1

            groupCells: true,    // if set to true group cells that fit in carousel viewport

            watchCSS: true     // enable Flickity in CSS when element:after { content: 'flickity' }

            // ready events on options
            // on: {
            //     ready: () => {  console.log('Flickity ready');  }
            // }
        }
        this.flkty = new Flickity(this.slider, options);
        this.flkty.x = 0;           // var for continous scroll


        // ***** API *****
        this.currentIndex = this.flkty.selectedIndex;
        this.lastIndex    = this.currentIndex;
        this.currentSlide = this.flkty.selectedElement;
        this.lastSlide    = this.currentSlide;
        
        this.flkty.on( 'change', ( index ) => {
            this.onChange(index);
        });

        // stop autoPlay when dragging
        this.flkty.on( 'dragStart', ( index ) => {
        });

        // restart autoplay when current slide is settled
        this.flkty.on( 'settle', ( index ) => {
        });

        // Select slide on click
        this.flkty.on( 'staticClick', ( event, pointer, cellElement, cellIndex ) => {
            if ( typeof cellIndex == 'number' && cellIndex != this.flkty.selectedIndex) {
              this.flkty.selectCell( cellIndex );
            }
        });

        // init continuous scroll
        if (this.autoPlay) this.initContinousScroll();
    }


    // Continuous scrolling 
    // -----------------------------------------------

    initContinousScroll() {
        this.slider.addEventListener('mouseenter', e => this.pauseContinuousScroll(e));
        this.slider.addEventListener('focusin', e => this.pauseContinuousScroll(e));
        this.slider.addEventListener('mouseleave', e => this.playContinuousScroll(e));
        this.slider.addEventListener('focusout', e => this.playContinuousScroll(e));
        this.updateContinuousScroll();
    };

    updateContinuousScroll() {
        if (this.isPaused) return;
        if (this.flkty.slides) {
            this.flkty.x = (this.flkty.x - this.tickerSpeed) % this.flkty.slideableWidth;
            // console.log('this.flkty.x', (this.flkty.x - this.tickerSpeed));
            this.flkty.selectedIndex = this.flkty.dragEndRestingSelect();
            this.flkty.updateSelectedSlide();
            this.flkty.settle(this.flkty.x);
        }
        window.requestAnimationFrame(() => this.updateContinuousScroll());
    };
    
    pauseContinuousScroll() {
        this.isPaused = true;
    };
    
    playContinuousScroll() {
        if (this.isPaused) {
            this.isPaused = false;
            window.requestAnimationFrame(() => this.updateContinuousScroll());
        }
    };



    // Events 
    // -----------------------------------------------

    onChange(index) {
        // update current / last index and slide
        this.lastIndex    = this.currentIndex;
        this.currentIndex = index;
        this.lastSlide    = this.currentSlide;
        this.currentSlide = this.flkty.selectedElement;
        // console.log( 'Flickity change ', this.currentIndex, '('+this.lastIndex+')' );
    }



    
}
