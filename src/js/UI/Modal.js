
export default class Modal {

    constructor(el) {
        this.el       = el;
        this.btnClose = this.el.querySelector('.btn-close');
        this.id       = el.id;

        // store clickOutside function in a variable for removeEventListener to work later   
        this.clickOutsideEventListener = e => this.detectCloseOutside(e);
        this.pressEscEventListener = e => this.detectEscapeKey(e);
        
        this.init();
    }

    

    init() {
        this.btnClose.addEventListener('click', e => this.close(e) );

        // search opener buttons with data-modal=id
        if (this.id) {
            document.querySelectorAll(`[data-modal=${this.id}]`).forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    this.open(e);
                });
            });
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

