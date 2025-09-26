// Profile dropdown functionality
const profileDropdownToggle = document.getElementById('profileDropdownToggle');
const profileDropdown = document.getElementById('profileDropdown');
let isProfileDropdownOpen = false;

profileDropdownToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleProfileDropdown();
});

function toggleProfileDropdown() {
    isProfileDropdownOpen = !isProfileDropdownOpen;

    if (isProfileDropdownOpen) {
        profileDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
        profileDropdown.classList.add('opacity-100', 'visible', 'scale-100');
    } else {
        profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
        profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (isProfileDropdownOpen && !profileDropdown.contains(e.target) && !profileDropdownToggle.contains(e
        .target)) {
        toggleProfileDropdown();
    }
});

// Mobile menu functionality
const openSidebar = document.getElementById('openSidebar');
const closeSidebar = document.getElementById('closeSidebar');
const sidebar = document.getElementById('sidebar');
const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

openSidebar.addEventListener('click', () => {
    sidebar.classList.remove('-translate-x-full');
    mobileMenuOverlay.classList.remove('hidden');
});

closeSidebar.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    mobileMenuOverlay.classList.add('hidden');
});

mobileMenuOverlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    mobileMenuOverlay.classList.add('hidden');
});


// Color Configuration System
const colorConfig = {
    themes: {
        blue: {
            primary: {
                50: '#f0f9ff',
                500: '#0ea5e9',
                600: '#0284c7'
            }
        },
        emerald: {
            primary: {
                50: '#ecfdf5',
                500: '#10b981',
                600: '#059669'
            }
        },
        purple: {
            primary: {
                50: '#faf5ff',
                500: '#a855f7',
                600: '#9333ea'
            }
        },
        rose: {
            primary: {
                50: '#fff1f2',
                500: '#f43f5e',
                600: '#e11d48'
            }
        }
    },

    applyTheme(themeName) {
        const theme = this.themes[themeName];
        if (!theme) return;

        const root = document.documentElement;
        Object.entries(theme.primary).forEach(([shade, color]) => {
            root.style.setProperty(`--color-primary-${shade}`, color);
        });

        // Save preference
        localStorage.setItem('colorTheme', themeName);
    },

    init() {
        const savedTheme = localStorage.getItem('colorTheme') || 'blue';
        this.applyTheme(savedTheme);
    }
};

// Initialize color configuration
colorConfig.init();