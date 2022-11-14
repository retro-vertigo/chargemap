import Accordion from "../UI/Accordion";
import Form from "../UI/Form";
import LoadMore from "../LoadMore";

import { setSocialShareLink } from "../utils/utilsLib";
import SmoothScroll from "../utils/SmoothScroll";
import SliderProjects from "../blocks/SliderProjects";
import ReadMore from "../UI/ReadMore";
import ScrollHorizontal from "../UI/ScrollHorizontal";
import SliderImages from "../blocks/SliderImages";
import TitleAnimation from "../UI/TitleAnimation";
import Parallax from "../utils/Parallax";


// Init blocks with JS
export default function initBlocks () {

    //        Gutenberg blocks
    // ==============================================

    document.querySelectorAll('.block-push-projects').forEach( el => { new SliderProjects(el); });

    document.querySelectorAll('.block-values').forEach( el => { new ScrollHorizontal(el); });

    document.querySelectorAll('.js-slider-images-wrapper').forEach( el => { new SliderImages(el); });


    //        UI
    // ==============================================
    
    document.querySelectorAll('[data-accordion]').forEach( el => { new Accordion(el); });
    
    document.querySelectorAll('[data-readmore]').forEach( el => { new ReadMore(el); });

    // animate section title on scroll
    new TitleAnimation();

    
    
    //        Other modules
    // ==============================================
    
    document.querySelectorAll('.js-form-wrapper').forEach( el => { new Form(el); });
    
    // load more posts module on "Actualités" page
    if (document.getElementById('js-btn-loadmore')) new LoadMore();
    
    // document.querySelectorAll('.js-parallax-container').forEach( el => { new Parallax(el); });

    //        Social share links
    // ==============================================

    // set social share urls on links ([data-social-share])
    document.querySelectorAll('[data-social-share]').forEach(el => { setSocialShareLink(el); });
    

}  