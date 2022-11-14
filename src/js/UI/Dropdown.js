
export default class Dropdown {

    constructor(el) {
        this.el      = el;
        this.btn     = this.el.querySelector('[data-dropdown-trigger]');
        this.content = this.el.querySelector('[data-dropdown-content]');  // list to open / close

        // store clickOutside function in a variable for removeEventListener to work later   
        this.clickOutsideEventListener = e => this.detectClickOutside(e);
        
        this.init();
    }

    init() {
        this.btn.addEventListener('click', e => this.clickBtn(e) );
        // replace auto value in custom property with real value for transition
        this.measureContentHeight();
    }


    // Recalculate content expanded height
    measureContentHeight(e) {
        this.content.style.setProperty('--height-open', this.content.scrollHeight + 'px');
        // console.log('content.scrollHeight', this.content.scrollHeight, this.content.offsetHeight);
    }


    // Open / close dropdown
    clickBtn(e) {
        e.preventDefault();
        // e.stopPropagation();        // no click outside detection (comment if multiple dropdown)

        // close item
        if (this.el.classList.contains('is-active')) {
            this.closeContent();
        // open item    
        } else {
            this.openContent();
        }
    }
    
    // Close dropdown
    closeContent() {
        this.el.classList.remove('is-active');
        document.removeEventListener('click', this.clickOutsideEventListener);
    }

    // Open dropdown
    openContent() {
        this.measureContentHeight();
        this.el.classList.add('is-active');
        document.addEventListener('click', this.clickOutsideEventListener);
    }

    // Close dropdown if click outside 
    detectClickOutside(e) {
        if (!this.el.contains(e.target)) this.closeContent();
    }
}

