import SmoothScroll from "./utils/SmoothScroll";

export default class JobForm {

    constructor() {
        this.form = document.getElementById('js-job-form');
        this.btnShowJobForm = document.getElementById('js-btn-show-job-form');

        this.init();
    }

    init () {
        this.btnShowJobForm.addEventListener('click', e => this.showForm(e) );
        
        // show job form immediately if form error or form confirmation after reload and submission
        if (this.form.querySelector('.gform_wrapper.gform_validation_error') || this.form.querySelector('.gform_confirmation_wrapper')) {
            this.form.classList.remove('visually-hidden');
            this.btnShowJobForm.style.display = 'none';
        }
    }


    // show job form
    showForm(e) {
        this.form.classList.remove('visually-hidden');
        this.btnShowJobForm.style.display = 'none';
        SmoothScroll.scrollToTarget(document.getElementById('js-job-form'));
    }
}