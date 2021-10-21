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
        }, 10000)
    }, 5000)
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
