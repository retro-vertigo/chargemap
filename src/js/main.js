import $ from 'jquery';
window.$ = $;
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
}
   

initSite();
