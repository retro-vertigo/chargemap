import Tabs from "../utils/Tabs";
import SliderLogos from "../blocks/SliderLogos";
import SliderTestimonial from "../blocks/SliderTestimonial";


// Init blocks with JS
export default function initBlocks () {

    //        Gutenberg blocks
    // ==============================================

    document.querySelectorAll('.block-tabs').forEach( el => { new Tabs(el); });

    document.querySelectorAll('.block-logos').forEach( el => { new SliderLogos(el); });

    document.querySelectorAll('.block-testimonial').forEach( el => { new SliderTestimonial(el); });

    // document.querySelectorAll('.block-push-projects').forEach( el => { new SliderProjects(el); });

    // document.querySelectorAll('.block-values').forEach( el => { new ScrollHorizontal(el); });

    // document.querySelectorAll('.js-slider-images-wrapper').forEach( el => { new SliderImages(el); });


    //        UI
    // ==============================================
    
    
    //        Other modules
    // ==============================================

}  