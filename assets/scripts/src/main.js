import 'hamburgers/dist/hamburgers.css';
import '../../styles/scss/style.scss';

import $ from 'jquery';
import 'what-input';
import 'foundation-sites';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';

window.$ = $;
window.jQuery = $;

gsap.registerPlugin(
	ScrollTrigger,
	ScrollSmoother
);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollSmoother = ScrollSmoother;

import '../functions.js';

$(document).foundation();