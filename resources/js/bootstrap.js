import axios from 'axios'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Progressive Web App Helpers
function isAppInstalled() {
    return (
        ('standalone' in navigator && navigator.standalone) ||
        window.matchMedia('(display-mode: standalone)').matches
    )
}

window.showSnackBar = function () {
    let snackBar = document.getElementById('install-snackbar')

    setTimeout(() => {
        snackBar.style.display = 'block'
        setTimeout(() => {
            snackBar.remove()
        }, 10_000)
    }, 3_000)
}

window.showNotificationSnackBar = function () {
    if ('Notification' in window && Notification.permission !== 'granted') {
        const timeoutDelay = isAppInstalled() ? 3_000 : 13_000

        setTimeout(() => {
            let snackBar = document.getElementById('notification-snackbar')
            snackBar.style.display = 'block'
            setTimeout(() => {
                snackBar.remove()
            }, 10_000)
        }, timeoutDelay)
    }
}

window.requestNotificationPermission = function () {
    if ('Notification' in window) {
        Notification.requestPermission().then(permission => {
            console.log('Notification permission:', permission)
            let snackBar = document.getElementById('notification-snackbar')
            snackBar.style.display = 'none'
        })
    }
}

let deferredPrompt = null

window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault()
    deferredPrompt = e

    if (location.pathname === '/home') {
        showSnackBar()
    }
})

window.showInstallPromotion = function () {
    if (deferredPrompt) {
        deferredPrompt.prompt()
        deferredPrompt = null
    }
}

window.showNotificationSnackBar()

document.addEventListener("DOMContentLoaded", () => {
    const avatarBtn = document.getElementById("navbarUserMenu");
    const dropdown = document.getElementById("dropdownMenu");

    avatarBtn.addEventListener("click", () => {
        dropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", (e) => {
        if (!avatarBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });
});
