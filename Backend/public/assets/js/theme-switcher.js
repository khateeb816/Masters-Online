/**
 * Theme Switcher for Dashtreme Admin
 * This script handles theme switching functionality
 */

// Apply saved theme on page load
document.addEventListener('DOMContentLoaded', function () {
    // Load saved theme
    var savedTheme = localStorage.getItem('dashtremeTheme');
    if (savedTheme) {
        document.body.className = 'bg-theme ' + savedTheme;
    }
}); 