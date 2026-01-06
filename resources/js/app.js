import './bootstrap';

async function registerDailyReminder() {
    if (!('serviceWorker' in navigator)) return;

    const registration = await navigator.serviceWorker.ready;

    if ('periodicSync' in registration) {
        try {
            const status = await navigator.permissions.query({
                name: 'periodic-background-sync',
            });

            if (status.state === 'granted') {
                await registration.periodicSync.register('daily-reminder', {
                    minInterval: 24 * 60 * 60 * 1000, // 1 day
                });
                console.log('✅ Periodic Background Sync registered');
                return;
            }
        } catch (e) {
            console.warn('Periodic sync failed, falling back');
        }
    }

    if ('SyncManager' in window) {
        try {
            const tags = await registration.sync.getTags();
            if (!tags.includes('daily-reminder')) {
                await registration.sync.register('daily-reminder');
                console.log('⚠️ Using one-off Background Sync');
                return;
            }
        } catch (e) {
            console.warn('One-off sync failed, falling back');
        }
    }

    fallbackInPageReminder();
}

function fallbackInPageReminder() {
    if (Notification.permission !== 'granted') return;

    const LAST_KEY = 'last-diary-reminder';
    const last = Number(localStorage.getItem(LAST_KEY));
    const now = Date.now();

    if (!last || now - last > 24 * 60 * 60 * 1000) {
        new Notification('Your Daily Diary Reminder', {
            body: 'Take a moment to write your thoughts today ✍️',
            icon: '/icons/old/icons-192.png',
        });

        localStorage.setItem(LAST_KEY, now);
        console.log('📌 In-page reminder used');
    }
}

document.addEventListener(
    'click',
    async () => {
        await registerDailyReminder();
    },
    { once: true }
);

// ---------------- UTILS ----------------
const DAY = 24*60*60*1000;
const now = ()=>Date.now();
const isIOS = ()=> /iphone|ipad|ipod/i.test(navigator.userAgent);
const isStandalone = ()=> window.navigator.standalone===true;
const trackGA = (event, params={})=>{ window.dataLayer = window.dataLayer||[]; window.dataLayer.push({event,...params}); };

// ---------------- A/B COPY ----------------
const COPY = {
    A: { title:'Install Ediary 📓', body:'Write offline, faster access, private.', cta:'Install App', icon:'/icons/android-icon-192x192.png' },
    B: { title:'Make Ediary your Daily Habit ✨', body:'Install & get daily reminders.', cta:'Add to Home Screen', icon:'/icons/android-icon-192x192.png' }
};
function getVariant(){ let v=localStorage.getItem('pwa:variant'); if(!v){v=Math.random()<0.5?'A':'B'; localStorage.setItem('pwa:variant',v);} return v; }

// ---------------- VISIT + STAY ----------------
(function trackVisits(){
    const today=new Date().toISOString().slice(0,10);
    const visits=JSON.parse(localStorage.getItem('pwa:visit_days')||'[]');
    if(!visits.includes(today)){ visits.push(today); localStorage.setItem('pwa:visit_days',JSON.stringify(visits)); }
})();
setTimeout(()=>{ localStorage.setItem('pwa:stay_10s','1'); maybeShowBanner(); },10000);

let deferredPrompt=null;
window.addEventListener('beforeinstallprompt', e=>{ e.preventDefault(); deferredPrompt=e; });
window.addEventListener('appinstalled', ()=>localStorage.setItem('pwa:installed','1'));

function applyCopy(){
    const v=getVariant(); const copy=COPY[v];
    const titleEl=document.getElementById('pwa-banner-title');
    const bodyEl=document.getElementById('pwa-banner-body');
    const ctaEl=document.getElementById('pwa-banner-cta');
    const iconEl=document.getElementById('pwa-banner-icon');

    if(isIOS() && !isStandalone()){
        titleEl.textContent='Add Ediary to Home Screen';
        bodyEl.textContent='Tap the Share icon → Add to Home Screen for quick access & reminders.';
        ctaEl.textContent='How to Add';
        iconEl.src='/icons/ios-icon-180x180.png';
    } else {
        titleEl.textContent=copy.title; bodyEl.textContent=copy.body;
        ctaEl.textContent=copy.cta; iconEl.src=copy.icon;
    }
}

function maybeShowBanner(){
    if(localStorage.getItem('pwa:installed') || localStorage.getItem('pwa:banner_disabled')) return;

    const stay=localStorage.getItem('pwa:stay_10s');
    const visits=JSON.parse(localStorage.getItem('pwa:visit_days')||'[]');
    const dismissed=Number(localStorage.getItem('pwa:banner_dismissed')||0);

    if(
        stay
        && visits.length>=2
        && now()-dismissed>7*DAY
    ){
        applyCopy();
        const banner=document.getElementById('pwa-banner');
        banner.classList.remove('opacity-0','translate-y-0','hidden');
        banner.classList.add('opacity-100','translate-y-[-20px]');
        trackGA('pwa_banner_shown',{variant:getVariant()});
    }
}

function hideBanner(){
    const banner=document.getElementById('pwa-banner');
    banner.classList.add('opacity-0','translate-y-0');
    setTimeout(()=>banner.classList.add('hidden'),500);
}

async function showNotificationPrompt(){
    if(!('Notification' in window)) return;
    const lastAsk=Number(localStorage.getItem('pwa:notif_asked')||0);
    if(Notification.permission==='default' && now()-lastAsk>7*DAY){
        localStorage.setItem('pwa:notif_asked', now());
        try{
            const perm=await Notification.requestPermission();
            trackGA('notification_permission',{permission:perm});
            if(perm==='granted') await registerDailyReminder();
        } catch(e){ console.warn(e); }
    } else if(Notification.permission==='granted'){
        await registerDailyReminder();
    }
}

function fallbackNotification(){
    if(Notification.permission!=='granted') return;
    const LAST='last-diary-reminder'; const last=Number(localStorage.getItem(LAST)||0);
    if(!last || now()-last>DAY){
        new Notification('Your Daily Diary Reminder',{body:'Take a moment to write your thoughts today ✍️',icon:'/icons/android-icon-192x192.png'});
        localStorage.setItem(LAST, now());
        trackGA('daily_reminder_fallback');
    }
}

function incrementEntryCount(){
    let count=Number(localStorage.getItem('pwa:entry_count')||0)+1;
    localStorage.setItem('pwa:entry_count', count);
    if(count>=3) localStorage.setItem('pwa:banner_disabled','1');
}
const diaryForm=document.getElementById('diary-form');
if(diaryForm) diaryForm.addEventListener('submit', ()=>{ incrementEntryCount(); });

maybeShowBanner();


function formatRelative(date, locale) {
    const seconds = Math.floor((Date.now() - date.getTime()) / 1000);

    if (seconds < 45) {
        return locale.startsWith('en') ? 'Just now' : null;
    }

    const rtf = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });

    const divisions = [
        { amount: 60, name: 'second' },
        { amount: 60, name: 'minute' },
        { amount: 24, name: 'hour' },
        { amount: 7, name: 'day' },
        { amount: 4.34524, name: 'week' },
        { amount: 12, name: 'month' },
        { amount: Infinity, name: 'year' },
    ];

    let duration = seconds;

    for (let i = 0; i < divisions.length; i++) {
        if (Math.abs(duration) < divisions[i].amount) {
            return rtf.format(-Math.round(duration), divisions[i].name);
        }
        duration /= divisions[i].amount;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('pwa-banner-cta')?.addEventListener('click', async ()=>{
        trackGA('pwa_banner_clicked');
        if(deferredPrompt){
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if(outcome==='accepted'){ localStorage.setItem('pwa:installed','1'); trackGA('pwa_install_accepted'); }
            else trackGA('pwa_install_rejected');
            deferredPrompt=null;
            hideBanner();
        } else if(isIOS() && !isStandalone()){
            alert('Tap the Share icon → Add to Home Screen to install Ediary.');
        } else {
            await showNotificationPrompt();
        }
    });

    document.getElementById('pwa-banner-dismiss')?.addEventListener('click', ()=>{
        localStorage.setItem('pwa:banner_dismissed', now());
        trackGA('pwa_banner_dismissed');
        hideBanner();
    });

    document.querySelectorAll('[data-time]').forEach(el => {
        const iso = el.dataset.time;
        const locale = navigator.language;

        const date = new Date(iso);
        if (isNaN(date)) return;

        const relative = formatRelative(date, locale);

        const absolute = date.toLocaleString(locale, {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
        });

        const target = el.querySelector('.js-date');
        if (target) {
            target.textContent = relative ?? absolute.split(',')[0];
        }

        el.title = absolute;
        el.setAttribute('datetime', date.toISOString());
    });
})
