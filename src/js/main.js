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


    // Gestion de la barre de notif sticky du plugin "Announcer"
    setTimeout(() => {
        const ancr = document.querySelector('.ancr-top-spacer');
        
        if(ancr) {
            let barHeight = ancr.offsetHeight;
            document.documentElement.style.setProperty('--notif-bar-height', `${barHeight}px`);
            
            // récupère la hauteur de la barre à chaque changement de taille (fermeture de la barre)
            const observer = new ResizeObserver(entries => {
                entries.forEach(entry => {
                    
                    if(entry.contentRect.height != barHeight) {
                        console.log('barHeight :', barHeight);
                        
                        barHeight = entry.contentRect.height;
                        document.documentElement.style.setProperty('--notif-bar-height', `${barHeight}px`);
                    }
                });
              });

            observer.observe(ancr); 
        }
        
    }, 100);
}
   

initSite();
