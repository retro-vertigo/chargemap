import Splitting from "splitting";

export default class TitleAnimation {

    constructor() {
        this.init();
    }

    init () {

        const titles = document.querySelectorAll('[data-splitting]');

        // split titles with break line, and wrap each line in <span>
        // Ex : Lorem<br>Ipsum<br>Dolor  -->  <span>Lorem</span><span>Ipsum</span><span>Dolor</span>
        titles.forEach(title => { 
            // const content = title.innerHTML;
            // console.log('content', content);
            const lines = title.innerText.trim().split('\n');
            const spans = lines.map(line => '<span>'+line+'</span>');  // -> <span>Lorem</span>
            title.innerHTML = spans.join(''); 
        });
        
        // split titles by words
        const results = Splitting({
            target: '[data-splitting]',
            by: "words",
            // whitespace: true
        });
    }  
}