// Apply dark mode immediately before page renders
(function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (isDarkMode || (prefersDark && !localStorage.getItem('darkMode'))) {
        document.documentElement.classList.add('dark-mode');
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle dark mode
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark-mode');
        
        // Update icon and text for all toggle buttons
        const toggleIcons = document.querySelectorAll('.toggle-icon');
        const toggleTexts = document.querySelectorAll('.toggle-text');
        const isDarkMode = document.documentElement.classList.contains('dark-mode');
        
        toggleIcons.forEach(icon => {
            icon.textContent = isDarkMode ? '☀️' : '🌙';
        });
        toggleTexts.forEach(text => {
            text.textContent = isDarkMode ? 'Light Mode' : 'Dark Mode';
        });
        
        // Save preference
        if (isDarkMode) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    }
    
    // Initialize icon and text based on current dark mode state
    function initializeIcon() {
        const isDarkMode = document.documentElement.classList.contains('dark-mode');
        const toggleIcons = document.querySelectorAll('.toggle-icon');
        const toggleTexts = document.querySelectorAll('.toggle-text');
        toggleIcons.forEach(icon => {
            icon.textContent = isDarkMode ? '☀️' : '🌙';
        });
        toggleTexts.forEach(text => {
            text.textContent = isDarkMode ? 'Light Mode' : 'Dark Mode';
        });
    }

    // Desktop dark mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDarkMode();
        });
    }

    // Mobile dark mode toggle
    const darkModeToggleMobile = document.getElementById('dark-mode-toggle-mobile');
    if (darkModeToggleMobile) {
        darkModeToggleMobile.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDarkMode();
        });
    }
    
    // Initialize icons on page load
    initializeIcon();
});