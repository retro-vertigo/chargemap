
export default class Tabs {

    constructor(el) {
        if(el) {
            this.el       = el;
            this.btnsTabs = this.el.querySelectorAll('[role="tab"]');
            this.tabPanels = this.el.querySelectorAll('[role="tabpanel"]');
            
            this.init();
        }
    }
    

    init() {
        this.btnsTabs.forEach(  el => {
            el.addEventListener('click', e => this.clickTab(e) );
        });
    }


    clickTab(e) {
        const target = e.currentTarget;
      
        // Remove all current selected tabs
        this.btnsTabs.forEach( t => t.setAttribute('aria-selected', false));
      
        // Set this tab as selected
        target.setAttribute('aria-selected', true);
        console.log('target', target);
        
        // Hide all tab panels
        this.tabPanels.forEach( p => p.setAttribute('hidden', true));
      
        // Show the selected panel
        this.el.querySelector(`#${target.getAttribute('aria-controls')}`).removeAttribute('hidden');
    }
}

