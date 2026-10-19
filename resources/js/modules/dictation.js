import { applySessionTranscript, insertTranscript, latestFinalTranscript } from './dictation-text';

const SpeechRecognition = window.SpeechRecognition ?? window.webkitSpeechRecognition;
const IS_ANDROID = /Android/i.test(navigator.userAgent);

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
    // Text the current Android recognition session has inserted, which its next result replaces.
    let session = null;

    const render = (message = '') => {
        button.setAttribute('aria-pressed', String(listening));
        label.textContent = listening ? 'Stop' : 'Dictate';
        status.textContent = message;
    };

    const write = ({ value, caret }) => {
        target.value = value;
        target.setSelectionRange(caret, caret);
        // Lets drafts, the character count and auto-resize react to dictated text.
        target.dispatchEvent(new Event('input', { bubbles: true }));
    };

    const insert = (transcript) => {
        write(insertTranscript(target.value, target.selectionStart, target.selectionEnd, transcript));
    };

    const replaceSession = (transcript) => {
        const result = applySessionTranscript(target.value, session, target.selectionStart, target.selectionEnd, transcript);
        session = result.session;
        write(result);
    };

    const stop = () => {
        listening = false;
        recognition?.stop();
        render();
    };

    const start = () => {
        recognition = new SpeechRecognition();
        recognition.lang = document.documentElement.lang || navigator.language || 'en-US';
        // Android cannot recognise continuously: Chrome there re-sends the growing utterance as new
        // final results, which repeats words. One utterance per session, restarted by onend, avoids it.
        recognition.continuous = !IS_ANDROID;
        recognition.interimResults = true;

        recognition.onstart = () => {
            session = null;
        };

        recognition.onresult = (event) => {
            let interim = '';

            for (let i = event.resultIndex; i < event.results.length; i++) {
                const result = event.results[i];

                if (!result.isFinal) {
                    interim += result[0].transcript;
                } else if (!IS_ANDROID) {
                    insert(result[0].transcript);
                }
            }

            // Each Android final result is the whole utterance so far, so it replaces the last one.
            if (IS_ANDROID) {
                const transcript = latestFinalTranscript(event.results);

                if (transcript) {
                    replaceSession(transcript);
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
