/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import Vue from 'vue'
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = require('vue').default;

window.events = new Vue();
window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level })
}

window.showSnackBar = function(){
    let snackBar = document.getElementById('install-snackbar');
    setTimeout(()=>{
        snackBar.style.display = 'block';
        setTimeout(()=>{
            snackBar.remove();
        }, 10_000)
    }, 3_000)
}

window.showNotificationSnackBar = function(){
    if ('Notification' in window && Notification.permission !== 'granted') {
        let snackBar = document.getElementById('notification-snackbar');
        setTimeout(() => {
            snackBar.style.display = 'block';
            setTimeout(() => {
                snackBar.remove();
            }, 10_000)
        }, 14_000)
    }
}

window.requestNotificationPermission = function (){
    if ('Notification' in window) {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                console.log('Notification permission granted!');
            } else {
                console.log('Notification permission denied!');
            }

            // Hide the snackbar after the permission request
            let snackBar = document.getElementById('notification-snackbar');
            snackBar.style.display = 'none';
        });
    } else {
        console.log('Notifications are not supported in this browser.');
    }
}

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    if(location.pathname === '/home'){
        showSnackBar()
    }
});

window.showInstallPromotion = function(){
    deferredPrompt.prompt();
    deferredPrompt =null;
}

showNotificationSnackBar();
