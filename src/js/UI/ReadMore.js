import AOS from "../vendors/aos.min";

export default class ReadMore {

    constructor(el) {
        this.el = el;  // button

        if(this.el.parentNode.querySelector('[data-readmore-content]')) {
            this.hiddenContent = this.el.parentNode.querySelector('[data-readmore-content]');
        } else if(this.el.parentNode.parentNode.querySelector('[data-readmore-content]')) {
            this.hiddenContent = this.el.parentNode.parentNode.querySelector('[data-readmore-content]');
        }
        
        if(this.hiddenContent) this.init();
    }

    init() {
        this.el.addEventListener('click', e => this.clickBtn(e) );

        this.hiddenContent.style.setProperty('--height-open', this.hiddenContent.scrollHeight+'px');

        // refresh AOS position when accordion height change
        // this.hiddenContent.addEventListener('transitionend', e => {
        //     if (e.propertyName == 'height') AOS.refresh();
        // });
        
        // recalculate content expanded height when resize
        window.addEventListener('resize', e => this.measureContentHeight(e) );
    }

    // Open / close dropdown
    clickBtn(e) {
        e.preventDefault();
        
        if (this.hiddenContent.classList.contains('is-open')) {
            this.closeContent();
        } else {
            this.openContent();
        }
    }

    // Close content
    closeContent(item) {
        this.hiddenContent.classList.remove('is-open');
        this.el.textContent = 'Lire la suite';
        this.el.setAttribute('aria-expanded', 'false');
    }

    // Open content
    openContent(item) {
        this.measureContentHeight();
        this.hiddenContent.classList.add('is-open');
        this.el.textContent = 'Fermer';
        this.el.setAttribute('aria-expanded', 'true');
    }


    // Recalculate content expanded height when window resize 
    // TODO wrong height when resize up 
    measureContentHeight() {
        this.hiddenContent.style.setProperty('--height-open', this.hiddenContent.scrollHeight + 'px');
    }
}
