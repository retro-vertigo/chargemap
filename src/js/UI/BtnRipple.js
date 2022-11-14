export default class BtnRipple {

    constructor(el) {
        this.btn = el; 

        this.init();
    }

    init () {
        this.btn.addEventListener('click', e => this.createRipple(e) );
        this.btn.addEventListener('animationend', e => this.removeRipple(e) );
    }  

    createRipple(e) {
        const btnRect  = this.btn.getBoundingClientRect();
        const diameter = Math.max(btnRect.width, btnRect.height);
        const radius   = diameter / 2;

        const circle = document.createElement('span');
        circle.classList.add('ripple');
        circle.style.setProperty('--size', `${diameter}px`);
        circle.style.setProperty('--left', `${e.clientX - (btnRect.left + radius)}px`);
        circle.style.setProperty('--top', `${e.clientY - (btnRect.top + radius)}px`);
        this.btn.appendChild(circle);

        // e.preventDefault();
    }

    removeRipple(e) {
        const ripple = this.btn.querySelector('.ripple');
        if (ripple) ripple.remove();
    }
}