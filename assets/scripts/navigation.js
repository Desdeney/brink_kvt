// Navigation sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const navControl = document.getElementById('sidebar-control');
    const sidebar = document.getElementById('sidebarMenu');
    const showSidebarBtn = document.getElementById('showSidebarBtn');

    // Show sidebar
    if (showSidebarBtn && sidebar) {
        showSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('d-none');
            // Add animation class if needed
            sidebar.style.animation = 'slideIn 0.3s ease';
        });
    }

    // Hide sidebar
    if (navControl && sidebar) {
        navControl.addEventListener('click', function() {
            sidebar.classList.add('d-none');
        });
    }

    // Close sidebar when clicking outside (for mobile)
    document.addEventListener('click', function(event) {
        if (sidebar && !sidebar.classList.contains('d-none')) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = showSidebarBtn && showSidebarBtn.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle) {
                sidebar.classList.add('d-none');
            }
        }
    });

    // Close sidebar on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && sidebar && !sidebar.classList.contains('d-none')) {
            sidebar.classList.add('d-none');
        }
    });
});

// Add slide-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);
