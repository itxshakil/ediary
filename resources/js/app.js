import './bootstrap';
import { initRelativeDates } from './modules/relative-dates';
import { initFloatingShare } from './modules/share';
import { initPwaExperience } from './modules/pwa';
import { initViewTransitions } from './modules/view-transitions';
import { initDictation } from './modules/dictation';
import { initToasts } from './modules/toast';

// Before DOMContentLoaded, so classic scripts like offline-manager.js can call window.toast().
initToasts();
initPwaExperience();
initViewTransitions();

document.addEventListener('DOMContentLoaded', () => {
    initRelativeDates();
    initFloatingShare();
    initDictation();
});
