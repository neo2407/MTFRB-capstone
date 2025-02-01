var googleTranslateElementInit = function() {
    var language = localStorage.getItem('selectedLanguage') || 'en'; // Default to 'en' (English)
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,tl',  // 'en' for English, 'tl' for Filipino
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false // Prevents auto-translation
    }, 'google_translate_element');

    // Force interface language to English (UI control language)
    document.querySelector('html').setAttribute('lang', 'en');

    // Apply the stored language
    if (language !== 'en') {
      setTimeout(function() {
        var select = document.querySelector('.goog-te-combo');
        if (select) {
          select.value = language;
          select.dispatchEvent(new Event('change'));
        }
      }, 1000);
    }
};

// Store selected language when user changes it
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('goog-te-combo')) {
        localStorage.setItem('selectedLanguage', e.target.value);
    }
});
