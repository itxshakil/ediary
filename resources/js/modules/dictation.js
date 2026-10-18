import { insertTranscript } from './dictation-text';

const SpeechRecognition = window.SpeechRecognition ?? window.webkitSpeechRecognition;

// Errors that end dictation for good instead of restarting after a pause.
const FATAL_ERRORS = {
    'not-allowed': 'Microphone access is blocked. Allow it in your browser settings to dictate.',
    'service-not-allowed': 'Dictation is not available in this browser.',
    'audio-capture': 'No microphone was found.',
    network: 'Dictation needs an internet connection.',
    'language-not-supported': 'Dictation does not support your language yet.',
};

function setupDictation(button) {
    const target = document.getElementById(button.dataset.dictateTarget);
    const status = document.getElementById(`${button.id}-status`);
    const label = button.querySelector('[data-dictate-label]');

    if (!target || !status) {
        return;
    }

    let recognition = null;
    let listening = false;

    const render = (message = '') => {
        button.setAttribute('aria-pressed', String(listening));
        button.classList.toggle('dictate-button--listening', listening);
        label.textContent = listening ? 'Stop' : 'Dictate';
        status.textContent = message;
    };

    const insert = (transcript) => {
        const { value, caret } = insertTranscript(target.value, target.selectionStart, target.selectionEnd, transcript);
        target.value = value;
        target.setSelectionRange(caret, caret);
        // Lets drafts, the character count and auto-resize react to dictated text.
        target.dispatchEvent(new Event('input', { bubbles: true }));
    };

    const stop = () => {
        listening = false;
        recognition?.stop();
        render();
    };

    const start = () => {
        recognition = new SpeechRecognition();
        recognition.lang = document.documentElement.lang || navigator.language || 'en-US';
        recognition.continuous = true;
        recognition.interimResults = true;

        recognition.onresult = (event) => {
            let interim = '';

            for (let i = event.resultIndex; i < event.results.length; i++) {
                const result = event.results[i];

                if (result.isFinal) {
                    insert(result[0].transcript);
                } else {
                    interim += result[0].transcript;
                }
            }

            render(interim ? `Hearing: ${interim}` : 'Listening…');
        };

        recognition.onerror = (event) => {
            const message = FATAL_ERRORS[event.error];

            if (message) {
                listening = false;
                render(message);
            } else if (!['no-speech', 'aborted'].includes(event.error)) {
                console.error('Dictation failed:', event.error);
            }
        };

        // Browsers end recognition after a pause; keep going until the user stops.
        recognition.onend = () => {
            if (listening) {
                recognition.start();
            }
        };

        listening = true;
        recognition.start();
        target.focus();
        render('Listening…');
    };

    const syncOnline = () => {
        button.disabled = !navigator.onLine;
        button.title = navigator.onLine ? '' : 'Dictation needs an internet connection';

        if (!navigator.onLine && listening) {
            stop();
        }
    };

    button.addEventListener('click', () => (listening ? stop() : start()));
    target.form?.addEventListener('submit', () => listening && stop());
    window.addEventListener('online', syncOnline);
    window.addEventListener('offline', syncOnline);
    window.addEventListener('pagehide', () => recognition?.abort());

    syncOnline();
    button.closest('[data-dictate]').hidden = false;
}

export function initDictation() {
    if (!SpeechRecognition) {
        return;
    }

    document.querySelectorAll('[data-dictate-target]').forEach(setupDictation);
}
