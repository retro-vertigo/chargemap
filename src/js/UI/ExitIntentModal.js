import CookieService from "../utils/CookieService";

export default class ExitIntentModal {

    constructor(el) {
        this.el                 = el;
        this.btnClose           = this.el.querySelector('.btn-close');
        this.id                 = el.id;
        this.exitDetectionDelay = 3000;
        this.active             = true;

        // store clickOutside function in a variable for removeEventListener to work later   
        this.clickOutsideEventListener = e => this.detectCloseOutside(e);
        this.pressEscEventListener     = e => this.detectEscapeKey(e);
        this.mouseOutEventListener     = e => this.detectViewportExit(e);


        // ∆∆∆∆∆∆∆
        this.active             = false;
        this.exitDetectionDelay = 500;
        // console.log('getCookie', CookieService.getCookie('exitIntentShown'));
        // CookieService.deleteCookie('exitIntentShown');
        // CookieService.listCookies();
        // ∆∆∆∆∆∆∆
        
        if (!CookieService.getCookie('exitIntentShown') && this.active) this.init();
    }
    

    init() {
        this.btnClose.addEventListener('click', e => this.close(e) );
        
        // delay after page loaded before exit detection
        setTimeout(() => {
            document.addEventListener('mouseout', this.mouseOutEventListener);
        }, this.exitDetectionDelay);
    }


    detectViewportExit(e) {
        // If the mouse is near the top of the window, open the modal
        if (document.documentElement.clientWidth >= 768 && !e.toElement && !e.relatedTarget && e.clientY < 50) {
            document.removeEventListener('mouseout', this.mouseOutEventListener);
        
            // Show the modal after a short delay
            setTimeout(() => this.open(), 100);

            // Set the cookie when the modal is open
            CookieService.setCookie('exitIntentShown', true, 30);
            // CookieService.setCookie('exitIntentShown', true, new Date(new Date().getTime() + 6000));
        }
    }

    // Open modal
    open(e) {
        this.el.classList.add('is-open');
        document.body.classList.add('u-no-scroll');  
        document.addEventListener('click', this.clickOutsideEventListener);
        document.addEventListener('keydown', this.pressEscEventListener);
    }

    // Close modal
    close(e) {
        this.el.classList.remove('is-open');
        document.body.classList.remove('u-no-scroll');  
        document.removeEventListener('click', this.clickOutsideEventListener);
        document.removeEventListener('keydown', this.pressEscEventListener);
    }


    // Close if click outside (overlay)
    detectCloseOutside(e) {
        if (e.target.closest('.modal') && !e.target.closest('.modal__inner')) {
            this.close(e);
        }
    }

    // Close if ESC key pressed 
    detectEscapeKey(e) {
        if (e.keyCode === 27) {
            this.close(e);
        }
    }
}

