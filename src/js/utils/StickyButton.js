
export default class StickyButton {

    constructor(el) {
        if(el) {
            this.btnSticky   = document.getElementById('sticky-button');
            this.btnCover = document.querySelector('.block-cover-video .btn');
            
            if(window.innerWidth < 940 && this.btnSticky && this.btnCover) {
                this.init();
            }
        }
    }
    
    
    // Détecte quand le bouton du bloc cover disparait du viewport et affiche alors le bouton sticky 
    init() {
        this.observer = new IntersectionObserver(this.obCallback.bind(this), {
            // rootMargin: '0px 0px -100% 0px',
            rootMargin: '-75px 0px 0px 0px',
        });
        this.observer.observe(this.btnCover); 
    }

    obCallback(entries, observer) {
        entries.forEach(entry => {
            // entrée du bouton du bloc -> masque le bouton sticky
            if(entry.intersectionRatio > 0) {     
                this.btnSticky.classList.remove('is-show');
                console.log('in', entry.intersectionRatio);
            // sortie du bouton du bloc -> affiche le bouton sticky
            } else if (entry.intersectionRatio === 0) {
                this.btnSticky.classList.add('is-show');
                console.log('out', entry.intersectionRatio);
            }
        });
    }
}

