import { debounce, throttle, throttle2, throttle3 } from "../utils/utilsLib";

export default class HeaderSite {

    constructor(el) {
        // Singleton pattern
        if (!HeaderSite._instance) { 
            HeaderSite._instance = this;

            if (el) {
                this.header        = el;
                this.btnBurger     = document.getElementById('btn-burger');
                this.navResponsive = document.getElementById('nav-responsive-container');
                this.matchDesktop  = window.matchMedia("(min-width: 1200px)");
                this.lastScroll    = 0;
                
                this.init();
                this.initAccordion();
            }
        }
        return HeaderSite._instance;
    }


    init() {
        window.addEventListener('scroll', throttle(this.toggleStickyHeader, 90, this));
        this.toggleStickyHeader('onLoad');      // first call

        this.btnBurger.addEventListener('click', e => this.toggleNavResponsive(e));

        this.matchDesktop.addListener( m => this.detectCloseNavResponsive(m));
    }
   


    //        Responsive menu   
    // ==============================================

    // open / close reponsive menu
    toggleNavResponsive(e) {
        e.preventDefault();
        !this.header.classList.contains('is-open') ? this.openNavResponsive() : this.closeNavResponsive();
    }

    openNavResponsive() {
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        this.header.classList.add('is-open');
        this.header.classList.add('has-transition');
    }


    closeNavResponsive() {
        document.body.style.removeProperty('overflow');
        document.documentElement.style.removeProperty('overflow');
        this.header.classList.remove('is-open');
    }


    // close responsive menu when switch to large resolution (and remove nav transition )
    detectCloseNavResponsive(m) {
        // Changed to desktop
        if(m.matches) {
            if(this.header.classList.contains('is-open')) this.closeNavResponsive();
            this.header.classList.remove('has-transition');
        } 
    }


    //        Hide / show sticky header when scroll down / up
    // ==============================================

    toggleStickyHeader(callType) {
        let currentScroll = document.body.scrollTop || document.documentElement.scrollTop;
        
        if (currentScroll > 10) {
            this.header.classList.add('is-solid');
        } else {
            this.header.classList.remove('is-solid');
        }

        if (callType == 'onLoad') return;

        if (currentScroll > 200 && currentScroll > this.lastScroll) {
            this.header.classList.add('is-off-screen');
        } else {
            this.header.classList.remove('is-off-screen');
        }

        this.lastScroll = currentScroll;
    }




    //        Responsive accordion menu
    // ==============================================

    initAccordion() {
        this.itemsAccordion = this.header.querySelectorAll('.menu-item-has-children');
        this.itemsAccordion.forEach(  el => {

            // match only direct links of item
            el.querySelectorAll('.nav-primary__link').forEach( link => {
                if(link.parentElement == el) {
                    link.addEventListener('click', e => this.clickLinkAccordion(e, el) );
                    link.addEventListener('focus', e => this.clickLinkAccordion(e, el) );
                }
            });
        });
    }


    // Open / close accordion item
    clickLinkAccordion(e, item) {
        if (document.documentElement.clientWidth >= 1200) return;        // disable accordion on desktop
        e.preventDefault();

        // close item
        if (item.classList.contains('is-open')) {
            this.closeItemAccordion(item);
        // open item    
        } else {
            this.header.querySelectorAll('.menu-item-has-children.is-open').forEach(  el => {
                this.closeItemAccordion(el);
            });
            this.openItemAccordion(item);
        }
    }

    // Close item
    closeItemAccordion(item) {
        item.classList.remove('is-open');
    }

    // Open item
    openItemAccordion(item) {
        const content = item.querySelector('.submenu'); 
        content.style.setProperty('--height-open', content.scrollHeight + 'px');
        item.classList.add('is-open');
    }





    static getInstance() {
        if(!HeaderSite._instance) new HeaderSite();
        return HeaderSite._instance;
    }
}
