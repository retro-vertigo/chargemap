

export default class ScrollHorizontal {

    constructor(el) {
        this.el = el;  
        this.container = document.getElementById('js-list-values');
        this.triggerEl = document.getElementById('js-list-values-wrapper');
        
        if(window.innerWidth <= 576){
            return;
        }
        
        TweenLite.defaultEase = Linear.easeNone;
        this.controller = new ScrollMagic.Controller();

        this.windowWidth = window.innerWidth;
        this.containerWidth = this.container.scrollWidth;                   // largeur total overflow inclus
        this.widthToScroll = this.containerWidth - this.windowWidth;        // distance à faire scroller
        this.timeline = new TimelineMax().to(this.container, 1, { x: -this.widthToScroll });
        
        console.log('windowWidth :', this.windowWidth);
        console.log('containerWidth', this.containerWidth);
        console.log('widthToScroll', this.widthToScroll);

        
        this.scene = this.createScene();

        window.addEventListener('resize', e => this.onResize(e));
    }

    onResize() {
        this.windowWidth = window.innerWidth;
        this.containerWidth = this.container.scrollWidth;
        this.widthToScroll = this.containerWidth - this.windowWidth;
        this.timeline.kill();
        this.timeline = new TimelineMax().to(this.container, 1, { x: -this.widthToScroll });
        this.scene.destroy(true);
        this.scene = this.createScene();
        console.log('\n+ windowWidth :', this.windowWidth);
        console.log('+ containerWidth', this.containerWidth);
        console.log('+ widthToScroll', this.widthToScroll);
    }
    
    
    createScene() {
        return new ScrollMagic.Scene({
            triggerElement: this.triggerEl,
            triggerHook: "onCenter",
            offset: 125,
            duration: this.widthToScroll
        })
        .setPin(this.triggerEl)
        .setTween(this.timeline)
        // .addIndicators({
        //     colorTrigger: "black",
        //     colorStart: "red",
        //     colorEnd: "green",
        // })
        .addTo(this.controller);
    }
}
// var createScene = () => {
    // // function createScene() {
    //     return new ScrollMagic.Scene({
    //         triggerElement: this.triggerEl,
    //         triggerHook: "onCenter",
    //         offset: 125,
    //         duration: this.widthToScroll
    //     })
    //     .setPin(this.triggerEl)
    //     .setTween(this.timeline)
    //     .addIndicators({
    //         colorTrigger: "black",
    //         colorStart: "red",
    //         colorEnd: "green",
    //     })
    //     .addTo(this.controller);
    // }


        // var slides = this.el.querySelectorAll('.item-value');
        // var noSlides = slides.length;
        // var slideWidth = $(".item-value").innerWidth();
        // var style = container.currentStyle || window.getComputedStyle(container);
        // var paddingLeft = parseInt(style.paddingLeft);
        // var containerWidth = slideWidth * noSlides + paddingLeft;



        // var container = document.getElementById('js-list-values');
        // var controller = new ScrollMagic.Controller();

        // var elementWidth = container.offsetWidth;
        // ∆∆∆∆∆

        // var tl = new TimelineMax();
        
        // var elementWidth = document.getElementById('container').offsetWidth;
        
        // var width = window.innerWidth - elementWidth;
        
        // var duration = elementWidth / window.innerHeight * 100;
        
        // var official = duration + '%';
        
        // tl.to('.container', 5, {x: width, ease: Power0.easeNone});
        
        // var scene1 = new ScrollMagic.Scene({
        //     triggerElement: '.container',
        //     triggerHook: 0,
        //     duration: official
        // })
        // .setPin('.container')
        // .setTween(tl)
        // .addTo(controller);