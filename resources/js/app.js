import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                // Primary color scheme - easily customizable
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e'
                },
                // Secondary color scheme
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a'
                }
            }
        }
    }
}


// Theme toggle functionality
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;

// Check for saved theme or default to light
const savedTheme = localStorage.getItem('theme') || 'light';
html.classList.toggle('dark', savedTheme === 'dark');

themeToggle.addEventListener('click', () => {
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
});

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

// Charts initialization
window.addEventListener('load', () => {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenue',
                data: [1200000, 1900000, 1500000, 2200000, 2800000, 2400000, 3100000],
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'Rp' + (value / 1000000) + 'M';
                        }
                    }
                }
            }
        }
    });

    // Booking Chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'doughnut',
        data: {
            labels: ['Confirmed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
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

// Example: Change theme programmatically
// colorConfig.applyTheme('emerald'); // Green theme
// colorConfig.applyTheme('purple'); // Purple theme
// colorConfig.applyTheme('rose'); // Pink/Rose theme

