/**
 * Cookie Consent Manager
 *
 * This script handles the display and logic of a cookie consent banner and settings modal.
 * It allows for granular consent and automates the activation of third-party scripts
 * based on user preferences stored in localStorage. It also includes specific logic
 * to manage UI elements, such as a Typecho comment form.
 */
document.addEventListener('DOMContentLoaded', () => {

    const COOKIE_CONSENT_KEY = 'cookie_consent_settings';

    // DOM Element References
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

    /**
     * Default consent state. The keys here ('functional', 'analytics') must
     * correspond to the 'data-consent-category' attributes in the HTML script tags.
     */
    let consentSettings = {
        necessary: true,
        functional: false,
        analytics: false
    };

    /**
     * Saves the current consent settings to localStorage, hides the UI,
     * and triggers actions based on the new settings.
     */
    function saveConsentSettings() {
        localStorage.setItem(COOKIE_CONSENT_KEY, JSON.stringify(consentSettings));
        hideAllInterfaces();
        showManageTrigger();
        runConsentBasedActions();
    }

    /**
     * Loads consent settings from localStorage.
     * @returns {boolean} - True if settings were found and loaded, false otherwise.
     */
    function loadConsentSettings() {
        const savedSettings = localStorage.getItem(COOKIE_CONSENT_KEY);
        if (savedSettings) {
            consentSettings = JSON.parse(savedSettings);
            return true;
        }
        return false;
    }

    /**
     * Updates the toggle switches in the settings modal to reflect the current state.
     */
    function updateModalToggles() {
        functionalToggle.checked = consentSettings.functional;
        analyticsToggle.checked = consentSettings.analytics;
    }

    // --- UI Control Functions ---

    function showBanner() { banner.style.display = 'block'; }
    function hideBanner() { banner.style.display = 'none'; }
    function showModal() {
        updateModalToggles();
        modal.style.display = 'flex';
    }
    function hideModal() { modal.style.display = 'none'; }
    function showManageTrigger() { manageTrigger.style.display = 'flex'; }
    function hideAllInterfaces() {
        hideBanner();
        hideModal();
    }

    // --- Event Handlers ---

    acceptAllBtn.addEventListener('click', () => {
        consentSettings.functional = true;
        consentSettings.analytics = true;
        saveConsentSettings();
    });

    acceptAllModalBtn.addEventListener('click', () => {
        consentSettings.functional = true;
        consentSettings.analytics = true;
        saveConsentSettings();
    });

    savePrefsBtn.addEventListener('click', () => {
        consentSettings.functional = functionalToggle.checked;
        consentSettings.analytics = analyticsToggle.checked;
        saveConsentSettings();
    });

    customizeBtn.addEventListener('click', () => {
        hideBanner();
        showModal();
    });

    /**
     * Handles closing the modal without saving preferences.
     * If no choice has been made yet, it shows the main banner again.
     */
    function handleModalCloseWithoutSaving() {
        hideModal();
        if (!localStorage.getItem(COOKIE_CONSENT_KEY)) {
            showBanner();
        }
    }

    closeModalBtn.addEventListener('click', handleModalCloseWithoutSaving);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            handleModalCloseWithoutSaving();
        }
    });

    manageTrigger.addEventListener('click', showModal);

    // --- Action Execution Based on Consent ---

    /**
     * A central function to run all actions that depend on user consent.
     * This includes activating scripts and managing UI elements.
     */
    function runConsentBasedActions() {
        activateScriptsByConsent();
        manageTypechoCommentForm();
    }

    /**
     * Scans the document for scripts with 'type="text/plain"' and a
     * 'data-consent-category' attribute. If consent for that category has
     * been given, it activates the script by replacing it with an executable version.
     */
    function activateScriptsByConsent() {
        const pendingScripts = document.querySelectorAll('script[type="text/plain"][data-consent-category]');

        pendingScripts.forEach(script => {
            const category = script.getAttribute('data-consent-category');
            if (consentSettings[category]) {
                const newScript = document.createElement('script');
                script.getAttributeNames().forEach(attrName => {
                    newScript.setAttribute(attrName, script.getAttribute(attrName));
                });
                newScript.setAttribute('type', 'text/javascript');
                newScript.innerHTML = script.innerHTML;
                script.parentNode.replaceChild(newScript, script);
                console.log(`Activated script for consent category: ${category}`);
            }
        });
    }

    /**
     * Manages the visibility of Typecho's comment form user fields
     * based on 'functional' cookie consent.
     */
    function manageTypechoCommentForm() {
        const userDetails = document.getElementById('comment-user-details');
        const consentPrompt = document.getElementById('comment-consent-prompt');

        // Proceed only if the comment form elements exist on the current page.
        if (!userDetails || !consentPrompt) {
            return;
        }

        const inputs = userDetails.querySelectorAll('input');

        if (consentSettings.functional) {
            // If consent is given, show the fields and hide the prompt.
            userDetails.style.display = 'block';
            consentPrompt.style.display = 'none';
            inputs.forEach(input => input.disabled = false);
        } else {
            // If consent is not given, hide the fields and show the prompt.
            userDetails.style.display = 'none';
            consentPrompt.style.display = 'block';
            inputs.forEach(input => input.disabled = true);
        }
    }

    /**
     * Initializes the cookie consent manager on page load.
     */
    function initialize() {
        if (loadConsentSettings()) {
            // User has already made a choice.
            showManageTrigger();
            runConsentBasedActions();
        } else {
            // First-time visitor.
            showBanner();
            // Also run actions for the default (denied) state.
            manageTypechoCommentForm();
        }
    }

    // Start the process.
    initialize();
});