/**
 * Cookie Consent Manager
 * Features: Event-driven updates, auto-activation, and settings management.
 */
document.addEventListener('DOMContentLoaded', () => {

    const COOKIE_CONSENT_KEY = 'cookie_consent_settings';

    // UI Elements
    const banner = document.getElementById('cookie-consent-banner');
    const modal = document.getElementById('cookie-settings-modal');
    const manageTrigger = document.getElementById('manage-consent-trigger');
    const acceptAllBtn = document.getElementById('cookie-accept-all-btn');
    const customizeBtn = document.getElementById('cookie-customize-btn');
    const closeModalBtn = document.getElementById('cookie-modal-close-btn');
    const savePrefsBtn = document.getElementById('cookie-save-prefs-btn');
    const acceptAllModalBtn = document.getElementById('cookie-accept-all-modal-btn');
    const functionalToggle = document.getElementById('cookie-functional');
    const analyticsToggle = document.getElementById('cookie-analytics');

    // Default State
    let consentSettings = {
        necessary: true,
        functional: false,
        analytics: false
    };

    /**
     * Dispatch a custom event so other parts of the page (like the comment form)
     * know that consent settings have changed.
     */
    function broadcastUpdate() {
        const event = new CustomEvent('cookieConsentUpdated', { detail: consentSettings });
        window.dispatchEvent(event);
    }

    function saveConsentSettings() {
        localStorage.setItem(COOKIE_CONSENT_KEY, JSON.stringify(consentSettings));
        hideAllInterfaces();
        showManageTrigger();
        runConsentBasedActions();
        broadcastUpdate(); // Notify the comment form immediately
    }

    function loadConsentSettings() {
        const savedSettings = localStorage.getItem(COOKIE_CONSENT_KEY);
        if (savedSettings) {
            try {
                consentSettings = JSON.parse(savedSettings);
                return true;
            } catch (e) {
                return false;
            }
        }
        return false;
    }

    function updateModalToggles() {
        if(functionalToggle) functionalToggle.checked = consentSettings.functional;
        if(analyticsToggle) analyticsToggle.checked = consentSettings.analytics;
    }

    // --- UI Helpers ---
    function showBanner() { if(banner) banner.style.display = 'block'; }
    function hideBanner() { if(banner) banner.style.display = 'none'; }
    function showModal() { updateModalToggles(); if(modal) modal.style.display = 'flex'; }
    function hideModal() { if(modal) modal.style.display = 'none'; }
    function showManageTrigger() { if(manageTrigger) manageTrigger.style.display = 'flex'; }
    function hideAllInterfaces() { hideBanner(); hideModal(); }

    // --- Actions ---

    /**
     * Activates third-party scripts (e.g., GA4) based on consent.
     */
    function activateScriptsByConsent() {
        const pendingScripts = document.querySelectorAll('script[type="text/plain"][data-consent-category]');
        pendingScripts.forEach(script => {
            const category = script.getAttribute('data-consent-category');
            if (consentSettings[category]) {
                const newScript = document.createElement('script');
                Array.from(script.attributes).forEach(attr => {
                    newScript.setAttribute(attr.name, attr.value);
                });
                newScript.setAttribute('type', 'text/javascript'); // Activate
                newScript.innerHTML = script.innerHTML;
                script.parentNode.replaceChild(newScript, script);
                console.log(`[CookieManager] Activated script: ${category}`);
            }
        });
    }

    function runConsentBasedActions() {
        activateScriptsByConsent();
        // Comment form is now handled by its own event listener,
        // but we can trigger an update just in case.
        broadcastUpdate();
    }

    // --- Event Listeners ---

    if(acceptAllBtn) acceptAllBtn.addEventListener('click', () => {
        consentSettings.functional = true;
        consentSettings.analytics = true;
        saveConsentSettings();
    });

    if(acceptAllModalBtn) acceptAllModalBtn.addEventListener('click', () => {
        consentSettings.functional = true;
        consentSettings.analytics = true;
        saveConsentSettings();
    });

    if(savePrefsBtn) savePrefsBtn.addEventListener('click', () => {
        consentSettings.functional = functionalToggle.checked;
        consentSettings.analytics = analyticsToggle.checked;
        saveConsentSettings();
    });

    if(customizeBtn) customizeBtn.addEventListener('click', () => {
        hideBanner();
        showModal();
    });

    function handleModalCloseWithoutSaving() {
        hideModal();
        if (!localStorage.getItem(COOKIE_CONSENT_KEY)) {
            showBanner();
        }
    }

    if(closeModalBtn) closeModalBtn.addEventListener('click', handleModalCloseWithoutSaving);
    if(modal) modal.addEventListener('click', (e) => {
        if (e.target === modal) handleModalCloseWithoutSaving();
    });

    if(manageTrigger) manageTrigger.addEventListener('click', showModal);

    // --- Initialization ---

    function initialize() {
        if (loadConsentSettings()) {
            // User has visited before
            showManageTrigger();
            runConsentBasedActions();
        } else {
            // First time visitor
            showBanner();
            // Broadcast default (denied) state to ensure UI is correct
            broadcastUpdate();
        }
    }

    initialize();
});