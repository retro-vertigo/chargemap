import * as easings from "./easings";

export default class SmoothScroll {

    // Smooth scroll to element
    static scrollToTarget(target, duration='auto', easing='easeInOutCubic', offset=0, callback) {
        // stop scroll if rAF is already running
        cancelAnimationFrame(SmoothScroll.rafScrollId);     

        // Y offset for sticky header
        if (document.getElementById('header-site')) offset -= document.getElementById('header-site').offsetHeight;
        
        const easingFunc  = easings[easing];
        const scrollStart = window.pageYOffset;
        const targetTop   = target.getBoundingClientRect().top;
        const scrollDelta = targetTop + offset;
        const startTime   = performance.now();
        
        // variable duration calculated with the distance between current position and target
        if (duration == 'auto') {
            duration = Math.floor(Math.abs(scrollDelta) / 1.2);
            duration = Math.min(Math.max(duration, 800), 1600);
        }

        const doScroll = () => {
            const time    = performance.now() - startTime;      // time elapsed
            const percent = Math.min(time / duration, 1);       // percent between [0-1]
            window.scrollTo(0, scrollStart + scrollDelta * easingFunc(percent));
            
            if (time < duration) {
                SmoothScroll.rafScrollId = requestAnimationFrame(doScroll);
            } else {
                if (callback) callback();
            }
        };
        SmoothScroll.rafScrollId = requestAnimationFrame(doScroll);
    };
}
