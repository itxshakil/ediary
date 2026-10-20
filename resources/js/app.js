import './bootstrap';
import { initRelativeDates } from './modules/relative-dates';
import { initFloatingShare } from './modules/share';
import { initPwaExperience } from './modules/pwa';
import { initDictation } from './modules/dictation';
import { initToasts } from './modules/toast';
import { initMoodPickers } from './modules/mood-picker';
import { initOfflineSync } from './modules/offline-store';
import { initEntryForms } from './modules/entry-form';
import { initClickTracking } from './modules/analytics';
import { initPasswordToggles } from './modules/password-toggle';
import { initTimezoneFields } from './modules/timezone';

initToasts();
initClickTracking();
initPasswordToggles();
initPwaExperience();

document.addEventListener('DOMContentLoaded', () => {
    initRelativeDates();
    initFloatingShare();
    initDictation();
    initMoodPickers();
    initEntryForms();
    initTimezoneFields();
    initOfflineSync();
});
