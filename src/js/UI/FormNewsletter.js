
export default class FormNewsletter {

    constructor(el) {
        this.el         = el;
        this.form       = this.el.querySelector('form');
        this.feedback   = this.el.querySelector('.footer-newsletter__feedback');
        this.emailInput = this.el.querySelector('input[name="email"]');
        this.urlForm    = 'https://community.chargemap.com/newsletter/subscription/';

        this.current_lang      = newsletter_messages.current_lang;
        this.msg_invalid_email = newsletter_messages.invalid_email;
        this.msg_sending       = newsletter_messages.sending;
        this.msg_success       = newsletter_messages.success;
        this.msg_error         = newsletter_messages.error;

        this.init();
    }



    init() {
        this.form.addEventListener('submit', e => this.submit(e) );
    }

    submit(e) {
        e.preventDefault();
        let email = this.emailInput.value;
        
        // check email validation
        this.feedback.classList.remove('is-error');
        if (!this.emailIsValid(email)) {
            this.feedback.classList.add('is-error');
            this.feedback.textContent = this.msg_invalid_email;
            return;
        }

        // prepare to send data
        this.feedback.textContent = this.msg_sending;

        $.ajax({
            data: {
                email: email,
                lang: this.current_lang,
                action: 'submit_newsletter'
            },
            crossdomain: true,
            type       : 'post',
            url        : this.urlForm,
        })
        .done( () => {
            console.log('done');
            this.feedback.classList.remove('is-error');
            this.feedback.textContent = this.msg_success;

            this.emailInput.addEventListener('focus', (e) => {
                this.feedback.textContent = '';
            });
        })
        .fail( (xhr, textStatus, errorThrown) => {
            console.log('fail', xhr.status);
            if(xhr.status === 400) {
                console.log('already');
                
                // subscription already exists
            }
            this.feedback.classList.add('is-error');
            this.feedback.textContent = this.msg_error;

            this.emailInput.addEventListener('focus', (e) => {
                this.feedback.classList.remove('is-error');
                this.feedback.textContent = '';
            });
        });
    }

    emailIsValid(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
}

