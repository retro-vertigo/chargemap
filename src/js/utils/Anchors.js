import SmoothScroll from "./SmoothScroll";

export default class Anchors {

    constructor(el) {
        if(el) {
            this.el       = el;
            this.tabList = this.el.querySelector('.tablist');
            this.btnsTabs = this.el.querySelectorAll('.tablist__btn');

            
            // this.btnsTabsArray = [...this.el.querySelectorAll('.tablist__btn')];
            this.sections = this.el.querySelectorAll('.panel');
            this.observer = new IntersectionObserver(this.obCallback.bind(this), {
                // rootMargin: '0px 0px -100% 0px',
                // rootMargin: '-100px 0px -50% 0px',
                // rootMargin: '-240px 0px -50%  0px',
                rootMargin: '-49% 0px -50%  0px',
            });
            this.autoScrolling = false;     // freeze l'observer si clic direct sur un lien
            this.currentLink = null;
            
            this.init();
        }
    }

    init() {
        this.btnsTabs.forEach(  el => {
            el.addEventListener('click', e => this.clickTab(e) );
        });


        this.sections.forEach(section => { this.observer.observe(section); }  );
        // this.observer.observe(this.sections[1]);
        // this.observer.observe(this.sections[2]);
    }

    clickTab(e) {
        e.preventDefault();
        const target = e.currentTarget;
        // target.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'start' });

        let offset = - this.tabList.offsetHeight -10;
        SmoothScroll.scrollToTarget(document.querySelector(target.hash), 900, 'easeInOutCubic', offset, this.scrollComplete.bind(this));
        this.autoScrolling = true;
        

        // Active le lien
        this.btnsTabs.forEach(link => link.classList.remove('is-active'));
        this.currentLink = target;
        this.currentLink.classList.add('is-active');

        // target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
    }

    scrollComplete() {
        this.autoScrolling = false;

        // Active le lien aprés une fois le scroll terminé
        this.btnsTabs.forEach(link => link.classList.remove('is-active'));
        if(this.currentLink) this.currentLink.classList.add('is-active');
    }


    obCallback(entries, observer) {
        entries.forEach(entry => {
            
            // highlight du lien correspondant dans la nav quand section entre aprés la moitié de la hauteur du viewport
            const hash = `#${entry.target.id}`;
                //console.log('hash', hash.slice(-2));
                

            if(entry.intersectionRatio > 0) {     
                //console.log('\n•••IN section', hash.slice(-2), entry.intersectionRatio);
                
                // freeze l'observer si clic direct sur un lien
                if(!this.autoScrolling) {
                    this.btnsTabs.forEach(link => {
                        link.classList.remove('is-active');
                        if(link.hash === hash) {
                            link.classList.add('is-active');
                            link.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'start' });
                        }
                    })
                }
            // désactive quand section hors du viewport
            } else if (entry.intersectionRatio === 0) {
                //console.log('\n°°°OUT section', hash.slice(-2), entry.intersectionRatio);

                this.btnsTabs.forEach(link => {
                    if(link.hash === hash) {
                        link.classList.remove('is-active');
                    }
                })
            }
        });
    }
}

