import { isInViewport, getCoords, clamp } from "./utilsLib";

// import the Tornis store functions
import { 
    watchViewport, 
    unwatchViewport, 
    getViewportState,
    recalibrateOrientation
  } from '../vendors/tornis.min';



export default class Parallax {

    constructor() {
        this.items = document.querySelectorAll('[data-parallax]');
        this.init();
    }


    init () {
        // define a watched function, to be run on each update
        const updateValues = ({ size, scroll, orientation }) => {
            if (scroll.changed || size.changed || orientation.changed) this.doParallax();
        };
        
        // bind the watch function
        // By default this will run the function as it is added to the watch list
        watchViewport(updateValues);
    }


    doParallax() {
        let scrolled = window.pageYOffset;
        let windowH  = document.documentElement.clientHeight;
        
        this.items.forEach(el => {
            let rect   = getCoords(el);
            let enterY = rect.topFromDoc - windowH;
            let pct    = 100 - (rect.top + rect.height) * 100 / (windowH + rect.height);
            
            // element on top of the page, already visible if no scroll
            if(rect.topFromDoc < windowH) {
                enterY = 0;
                pct    = 100 - (rect.top + rect.height) * 100 / (rect.topFromDoc + rect.height);
            } 
            
            let ty = 0;
            let tx = 0;
            let rot = 0;
            let yPos = 0;

            // element is visible on window -> set parallax transformation
            if (isInViewport(el)) {
                
                if (el.dataset.parallaxRateY || el.dataset.parallaxRateX || el.dataset.parallaxAmpRotate) {
                    // parallax with translate Y
                    if (el.dataset.parallaxRateY) {
                        ty = pct * el.dataset.parallaxRateY;     // > 0, move upwards faster than scroll 
                    } 

                    // parallax with translate X
                    if (el.dataset.parallaxRateX) {
                        tx = pct * el.dataset.parallaxRateX;
                    }

                    // parallax with rotate (if amp = 40 -> from -20deg to 20deg 
                    if (el.dataset.parallaxAmpRotate) {
                        rot = (-el.dataset.parallaxAmpRotate/2) + (pct * el.dataset.parallaxAmpRotate) / 100;
                    } 
                    
                    el.style.transform = `translate3d(${tx}px, ${ty}px, 0)`;
                    // el.style.transform = `translate3d(${tx}px, ${ty}px, 0) rotate(${rot}deg)`;
                    
                    // console.log('rot', pct,  rot);
                // parallax with background position     
                } else {
                    el.dataset.rateBg = 1;
                    // data-rate-bg : [-1:1], < 0 move faster than scroll, > 0 move slower 
                    // yPos = 50 - el.dataset.rateBg * (scrolled / rect.bottomFromDoc * 50);            // old sys
                    yPos = 50 - el.dataset.rateBg * (pct/2);
                    el.style.objectPosition = `50% ${yPos}%`;
                }


            // element is outside of the window
            } else {
                // ty = 0;
                // console.log(scrolled + " [", enterY, rect.bottomFromDoc, ']');
            }
            // console.log('ty', rect.topFromDoc.toFixed(0));
            
            

            // ∆∆∆∆∆∆∆∆∆
            // if (!ty) ty = 0;
            // if (!yPos) yPos  = 0;
            // let output = '';
            // output += '<br>(rect.top + rect.height): ' + (rect.top + rect.height);
            // output += '<br>(rect.bottom): ' + (rect.bottom);
            // output += '<br>(rect): ' + (rect.topFromDoc + rect.height - scrolled );
            // output += '<br>------------------------';
            // output += '<br>windowH: ' + windowH;
            // output += '<br>isInViewport: ' + this.isInViewport(el);
            // output += '<br>scrolled: ' + scrolled;
            // output += '<br>enterY: ' + enterY;
            // output += '<br>------------------------';
            // output += '<br>topFromDoc / bottomFromDoc: ' + Math.floor(rect.topFromDoc) + ' / ' + Math.floor(rect.bottomFromDoc);
            // output += '<br>top / bottom: ' + Math.floor(rect.top) + ' / ' + Math.floor(rect.bottom);
            // output += '<br>------------------------';
            // output += '<br><strong>pct: </strong>' + pct.toFixed(0) + "% / " + ty.toFixed(0) + "px";
            // output += '<br>(scrolled - enterY): ' + (scrolled - enterY)+ "px";
            // output += '<br>------------------------';
            // output += '<br>objectPosition: ' + window.getComputedStyle(el,null).getPropertyValue("object-position") + "px";
            // output += '<br>yPos: ' + yPos.toFixed(0) + "%";
            // document.getElementById('parallax-status').innerHTML = output;
            // document.querySelector('.block-hero__title').innerHTML = `pct : ${pct.toFixed(0)}%`;
            // document.querySelector('.block-hero__title').innerHTML = `yPos : ${yPos.toFixed(0)}%`;
            
        });

        // 
    }



    

    doParallax2() {
        let scrolled = window.pageYOffset;
        let windowH  = document.documentElement.clientHeight;
        
        this.items.forEach(el => {
            let elTop    = el.offsetParent.offsetTop + el.offsetTop;
            let elBottom = elTop + el.offsetHeight;
            let enterY   = (elTop - windowH >= 0) ? elTop - windowH : 0; // 0 if element top is outside of the window
            let leaveY   = elBottom;

            let rect = this.getCoords(el);
    
            // element is visible on window -> set parallax transformation
            if (scrolled >= enterY && scrolled <= leaveY) {
              
              // parallax with background-position (data-rate-bg: [0, 50] )
              if (el.dataset.rateBg) {
                let yPos   = (50 - el.dataset.rateBg * scrolled/elBottom);
                // let coords = `50% 90%`;
                let coords = `50% ${yPos}%`;
                el.style.objectPosition = coords;
                // console.log('coords', yPos.toFixed(2), elBottom, scrolled);
                  // console.log('\nelTop / elBottom', elTop, elBottom);
                  // console.log('top / bottom', getCoords(el).height, getCoords(el).bottom);
                  // console.log('enterY / leaveY', enterY, leaveY);
                
              // parallax with translate Y (data-speed-y: [-1, 1] )
              } else {
                let ty = (scrolled - enterY) * -el.dataset.speedY;
                let transform = `translate3d(0, ${ty}px, 0)`;
                // el.style.transform = transform;
              }
    
            // element is outside of the window
            } else {
              console.log(enterY, leaveY, scrolled,  "---");
            }

            // ∆∆∆∆∆∆∆∆∆
            let output = '';
            output += 'windowH: ' + windowH;
            output += '<br>isInViewport: ' + this.isInViewport(el);
            output += '<br>scrolled: ' + scrolled;
            output += '<br>elTop: ' + elTop + " / ";
            output += '<br>elBottom: ' + elBottom;
            output += '<br>enterY / leaveY: ' + enterY + " / " + leaveY;
            output += '<br>(scrolled - enterY): ' + (scrolled - enterY);
            output += '<br>------------------------';

            output += '<br>rect.height: ' + rect.height;
            // output += '<br>rect.left / right: ' + Math.floor(rect.left) + ' / ' + Math.floor(rect.right);
            output += '<br>rect.topFromDoc / bottomFromDoc: ' + Math.floor(rect.topFromDoc) + ' / ' + Math.floor(rect.bottomFromDoc);
            output += '<br>rect.top: ' + Math.floor(rect.top);
            output += '<br>rect.bottom: ' + Math.floor(rect.bottom);


            // let pct = (rect.top + rect.height) * 100 / (windowH + rect.height) -50;

            // pct 0% when el is at bottom of vp, pct 100% when el is at the top of vp
            // >>> original position is at the bottom of vp
            let pct = 100 - (rect.top + rect.height) * 100 / (windowH + rect.height);

            // pct -50% when el is at bottom of vp, pct 50% when el is at the top of vp
            // >>> original position is on the center of vp
            // let pct = 50 - (rect.top + rect.height) * 100 / (windowH + rect.height);



            output += '<br><strong>pct: </strong>' + pct.toFixed(1);
            

            document.getElementById('parallax-status').innerHTML = output;
            
            // ratio negative -> ty decrease / ratio postive -> ty increase
            let ty = pct * -1.05;
            // let ty = (scrolled - enterY) * -0.2;
            let transform = `translate3d(0, ${ty}px, 0)`;
            el.style.transform = transform;
        });
        // 
    }

}