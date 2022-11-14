import AOS from "../vendors/aos.min";

export default class Accordion {

    constructor(el) {
        this.el          = el;
        this.items       = this.el.querySelectorAll('[data-accordion-item]');
        this.multiExpand = (this.el.dataset.multiExpand === 'true');           // default false
        
        this.init();
    }

    init() {
        this.items.forEach(  el => {
            el.querySelector('[data-accordion-trigger]').addEventListener('click', e => this.clickItem(e, el) );
            // replace auto value in custom property with real value for transition
            const content = el.querySelector('[data-accordion-content]'); 
            content.style.setProperty('--height-open', content.scrollHeight+'px');

            // refresh AOS position when accordion height change
            content.addEventListener('transitionend', e => {
                if (e.propertyName == 'height') AOS.refresh();
            });
        });

        // recalculate content expanded height when resize
        window.addEventListener('resize', e => this.measureContentHeight(e) );
    }


    // Recalculate content expanded height when window resize 
    // TODO wrong height when resize up 
    measureContentHeight(e) {
        this.items.forEach(  el => {
            // replace auto value in custom property with real value for transition
            const content = el.querySelector('[data-accordion-content]'); 
            content.style.setProperty('--height-open', content.scrollHeight + 'px');
            // if (el.dataset.id == 0) console.log('content.scrollHeight', content.scrollHeight, content.offsetHeight);
        });
    }


    // Open / close accordion item
    clickItem(e, item) {
        e.preventDefault();

        // close item
        if (item.classList.contains('is-open')) {
            this.closeItem(item);
        // open item    
        } else {
            // close others first
            if (!this.multiExpand) {
                this.el.querySelectorAll('[data-accordion-item].is-open').forEach(  el => this.closeItem(el) );
            }
            this.openItem(item);
        }
    }
    
    // Close item
    closeItem(item) {
        item.classList.remove('is-open');

        const btn = item.querySelector('[data-accordion-trigger]');
        btn.setAttribute('aria-expanded', 'false');
    }

    // Open item
    openItem(item) {
        const content = item.querySelector('[data-accordion-content]'); 
        content.style.setProperty('--height-open', content.scrollHeight + 'px');
        // console.log('ya', content.scrollHeight);
            
        item.classList.add('is-open');

        const btn = item.querySelector('[data-accordion-trigger]');
        btn.setAttribute('aria-expanded', 'true');
    }
}
