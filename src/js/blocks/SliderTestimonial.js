// *** import if no add-ons needed
import Flickity from '../vendors/flickity.pkgd.min.js'


export default class SliderTestimonial {

    constructor(el) {
        this.block    = el;
        this.slider   = this.block.querySelector('.slider-testimonial');

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
        this.slideWidth = 400;
        this.nbSlides =  this.slider.childElementCount;
        this.slidesTotalWidth =  this.nbSlides * this.slideWidth;

        // ∆∆∆∆∆∆∆∆∆∆∆∆∆
        // this.autoPlay      = false;
        // ∆∆∆∆∆∆∆∆∆∆∆∆∆

        if (this.block.classList.contains('is-admin'))  this.autoPlay = false;

        // Désactive l'autoplay sur mobile ou si la taille du viewport est plus grande que la bande d'image
        if (window.innerWidth < 576) this.autoPlay = false; 
        if (window.innerWidth >= this.slidesTotalWidth) this.autoPlay = false; 
        
        if (this.slider) this.init();
    }

    init () {
        // prevent FOUC on load
        this.slider.offsetHeight;      // trigger redraw for transition

        // ***** options *****
        let options = {
            selectedAttraction: 0.015,
            friction: 0.25,
            wrapAround: this.autoPlay,
            pageDots: false,
            prevNextButtons: false,
            cellAlign: 'left',
            pageDots: true,
            // contain: true,
            
            // groupCells: true,    // if set to true group cells that fit in carousel viewport
        }
        this.flkty = new Flickity(this.slider, options);
        this.flkty.x = 0;           // var for continous scroll

        // Select slide on click
        this.flkty.on( 'staticClick', ( event, pointer, cellElement, cellIndex ) => {
            if ( typeof cellIndex == 'number' && cellIndex != this.flkty.selectedIndex) {
              this.flkty.selectCell( cellIndex );
            }
        });

        // PATCH iOS 15 horizontal drag bug
        // https://github.com/metafizzy/flickity/issues/1177
        this.flkty.on('dragStart', () => (document.ontouchmove = () => false));
        this.flkty.on('dragEnd', () => (document.ontouchmove = () => true));

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
        if (window.innerWidth < 576) {
            cancelAnimationFrame(this.rafId);
            return;
        }  
        if (this.flkty.slides) {
            this.flkty.x = (this.flkty.x - this.tickerSpeed) % this.flkty.slideableWidth;
            // console.log('this.flkty.x', (this.flkty.x - this.tickerSpeed));
            this.flkty.selectedIndex = this.flkty.dragEndRestingSelect();
            this.flkty.updateSelectedSlide();
            this.flkty.settle(this.flkty.x);
        }
        this.rafId = requestAnimationFrame(() => this.updateContinuousScroll());
    };
    
    pauseContinuousScroll() {
        this.isPaused = true;
        cancelAnimationFrame(this.rafId);    
    };
    
    playContinuousScroll() {
        if (this.isPaused) {
            this.isPaused = false;
            this.rafId = requestAnimationFrame(() => this.updateContinuousScroll());
        }
    };
}
