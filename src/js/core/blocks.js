import Tabs from "../utils/Tabs";
import SliderLogos from "../blocks/SliderLogos";
import SliderTestimonial from "../blocks/SliderTestimonial";
import Anchors from "../utils/Anchors";
import StickyButton from "../utils/StickyButton";
import FormNewsletter from "../UI/FormNewsletter";
import SliderGuide from "../blocks/SliderGuide";
import SliderReplay from "../blocks/SliderReplay";


// Init blocks with JS
export default function initBlocks () {

    //        Gutenberg blocks
    // ==============================================

    document.querySelectorAll('.block-tabs').forEach( el => { new Tabs(el); });

    document.querySelectorAll('.block-anchors').forEach( el => { new Anchors(el); });

    document.querySelectorAll('.block-logos').forEach( el => { new SliderLogos(el); });

    document.querySelectorAll('.block-testimonial').forEach( el => { new SliderTestimonial(el); });

    document.querySelectorAll('.block-guide').forEach( el => { new SliderGuide(el); });

    document.querySelectorAll('.block-webinar-replay').forEach( el => { new SliderReplay(el); });

    //        UI
    // ==============================================
    
    new FormNewsletter(document.getElementById('footer-newsletter'));
    
    //        Other modules
    // ==============================================

    if(document.getElementById('sticky-button')) {
        new StickyButton(document.getElementById('sticky-button'));
    }

}  