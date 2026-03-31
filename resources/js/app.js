import './bootstrap';
import { initRelativeDates } from './modules/relative-dates';
import { initFloatingShare } from './modules/share';
import { initPwaExperience } from './modules/pwa';
import { initViewTransitions } from './modules/view-transitions';

initPwaExperience();
initViewTransitions();

document.addEventListener('DOMContentLoaded', () => {
    initRelativeDates();
    initFloatingShare();
});
