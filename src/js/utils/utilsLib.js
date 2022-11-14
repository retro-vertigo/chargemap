

// Display current breakpoint in debug box
export function debugBreakpoint() {
    const rwdStatus = document.createElement('div');
    rwdStatus.classList.add('rwd-status');
    document.body.insertAdjacentElement('afterbegin', rwdStatus);
};


// Fix 100vh in iOS and Chrome Android (css var --vh set with JS)
export function calculateViewportHeight(e) {
    
    // if resize, recalculate only for desktop (because repaint cause scroll jump on mobile)
    // if(e == undefined || window.innerWidth >= 576) {
        const vh = window.innerHeight * 0.01;   // get the viewport height multiple it by 1% to get a value for a vh unit
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    // }
};


// last call triggered
// https://codeburst.io/throttling-and-debouncing-in-javascript-b01cad5c8edf
export function throttle(func, wait, context) {
    let timeout = null;
    let lastCall = null;     // timestamp of the last function call

    return () => {
        const args = arguments

        if (lastCall === null) {     // first call immediately
            func.apply(context, args);
            lastCall = Date.now();
            // console.log('•lastRan', lastCall);
        } else {
            // console.log('clear', Date.now());
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // console.log('finally call', lastCall, Date.now());
                lastCall = Date.now();
                func.apply(context, args);
            }, wait - (Date.now() - lastCall));      // track when the function was last ran (if value is negative timeout called immediately)
        }
    }
}

// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. 
// If `triggerMode` is `start`, trigger the function on the leading edge
// If `triggerMode` is `end`, trigger the function on the trailing edge
// If `triggerMode` is `both`, trigger the function on the leading AND trailing edge
// @see https://davidwalsh.name/function-debounce
export function debounce(func, wait, context, triggerMode='end') {
    const triggerOnStart = triggerMode === 'both' || triggerMode === 'start';
    const triggerOnEnd = triggerMode === 'both' || triggerMode === 'end';
    let timeout = null;

    return () => {
        const args = arguments;
        if (triggerOnStart && !timeout) func.apply(context, args);     // callback func called BEFORE debounce timeout

        clearTimeout(timeout);          // restart timeout on each event
        timeout = setTimeout( () => {
            timeout = null;
            if (triggerOnEnd) func.apply(context, args);      // callback func called AFTER debounce
        }, wait);
    };
};




// set href social share links
// Documentation :
// https://cards-dev.twitter.com/validator
// https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/summary
// https://developers.facebook.com/tools/debug/
// https://developers.facebook.com/docs/sharing/messenger/web
// https://developers.pinterest.com/docs/widgets/save/?
// http://debug.iframely.com/
export function setSocialShareLink(el) {
    const site = el.dataset.socialShare;
    let url      = encodeURIComponent(document.querySelector('meta[property="og:url"]').content);
    let title    = encodeURIComponent(document.querySelector('meta[property="og:title"]').content);
    let hashtags = '';
    let via      = '';
    let urlShare = '';

                // url = 'https://www.petitsfreresdespauvres.fr/noel/';

    switch (site) {
        case 'facebook':
            urlShare = `http://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;

        case 'twitter':
            urlShare   = `https://twitter.com/intent/tweet/?url=${url}&text=${title}`;
            if (hashtags) urlShare += `&hashtags=${hashtags}`;
            if (via) urlShare += `&via=${via}`;
            break;

        case 'pinterest':
            urlShare = `https://www.pinterest.com/pin/create/button/?url=${url}&description=${title}`;
            break;

        case 'linkedin':
            urlShare = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
        
        case 'whatsapp':
            urlShare = `https://api.whatsapp.com/send?text=${text}%20${url}`;
            break;

        case 'messenger':
            urlShare = `fb-messenger://share?link=${url}`;
            break;

        case 'email':
            urlShare = `mailto:?body=${url}`;
            break;

        default:
            console.log('Sorry, we are out of ' + site + '.');
            return;
    }
    
    // fill href attribute
    el.href = urlShare;
    el.target = '_blank';
}





// Detect if an element is in viewport (any part of the element)
export function isInViewport(el) {
    const rect = el.getBoundingClientRect();

    return (
        rect.top + rect.height >= 0 &&
        rect.left + rect.width >= 0 &&
        rect.bottom - rect.height <= document.documentElement.clientHeight &&
        rect.right - rect.width <= document.documentElement.clientWidth
    );
} 



// Get document coordinates of the element relative to the document
export function getCoords(el) {
    const rect             = el.getBoundingClientRect();        // coords relative to the viewport
        rect.height        = Math.floor(rect.height);
        rect.width         = Math.floor(rect.width);
        rect.topFromDoc    = Math.floor(rect.top + window.pageYOffset);
        rect.bottomFromDoc = Math.floor(rect.bottom + window.pageYOffset);
        rect.leftFromDoc   = Math.floor(rect.left + window.pageXOffset);
        rect.rigthFromDoc  = Math.floor(rect.right + window.pageXOffset);
    return rect;
}



// Limit a number between a min / max value
export function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}


// Mobile detection
export function detectIfMobile() {
    let isMobile = false;   

    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) isMobile = true;
        
    if (isMobile) document.body.classList.add('is-mobile');
}



//        Debug
// ==============================================

// Log elements which causes body overflow with horizontal scrollbar
// https://css-tricks.com/findingfixing-unintended-body-overflow/
export function showOverflowElements() {
    let docWidth = document.documentElement.offsetWidth;

    document.querySelectorAll('*').forEach(el => {
        if (el.offsetWidth > docWidth) {
            el.style.outline = "1px solid red"; 
            console.log("# overflow",  el);
        }
    });
}