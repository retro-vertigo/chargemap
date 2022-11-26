import $ from 'jquery';
window.$ = $;
import AOS from './vendors/aos.min';
import initBlocks from "./core/blocks";
import HeaderSite from './core/HeaderSite';
import Fancybox from './vendors/jquery.fancybox.min';
import { debugBreakpoint, calculateViewportHeight, throttle, debounce } from "./utils/utilsLib";


function initSite () {
    // debugBreakpoint();

    new HeaderSite(document.getElementById('header-site'));

    // init blocks with JS (sliders...)
    initBlocks();

    // fix 100vh in iOS and Chrome Android (css var --vh set with JS)
    calculateViewportHeight();
    window.addEventListener('resize', debounce(calculateViewportHeight, 90, this));
 
    //        AOS animation
    // ==============================================

    // let aos_duration = 600;
    // if(window.innerWidth < 576) aos_duration = 600;
    // !!! hack : delay to init AOS after Slick init
    setTimeout(function(){
        AOS.init({
            duration: 600,
            once: true,
            easing: 'ease-out-quart',
            disable: true,
        });
        }, 30
    );
}
   

initSite();
