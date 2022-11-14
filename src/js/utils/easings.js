
// Some easing functions
// See https://gist.github.com/gre/1650294 and https://easings.net
// only considering the t value for the range [0, 1] => [0, 1]

// others easings (back / bounce) : https://github.com/AndrewRayCode/easing-utils/blob/master/src/easing.js

export const easeInOutQuad = (t) => (t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t);

export const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1);

export const easeInOutQuart = (t) => (t < 0.5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t);

export const easeInOutQuint = (t) => (t < 0.5 ? 16 * t * t * t * t * t : 1 + 16 * --t * t * t * t * t);

export const easeInOutSine = (t) => (1 + Math.sin(Math.PI * t - Math.PI / 2)) / 2;

export const easeInOutElastic = (t) => ((t -= 0.5) < 0 ? (0.02 + 0.01 / t) * Math.sin(50 * t) : (0.02 - 0.01 / t) * Math.sin(50 * t) + 1);

