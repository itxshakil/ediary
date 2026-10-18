import './bootstrap';
import { initRelativeDates } from './modules/relative-dates';
import { initFloatingShare } from './modules/share';
import { initPwaExperience } from './modules/pwa';
import { initDictation } from './modules/dictation';
import { initToasts } from './modules/toast';
import { initMoodPickers } from './modules/mood-picker';

// Before DOMContentLoaded, so classic scripts like offline-manager.js can call window.toast().
initToasts();
initPwaExperience();

document.addEventListener('DOMContentLoaded', () => {
    initRelativeDates();
    initFloatingShare();
    initDictation();
    initMoodPickers();
});
