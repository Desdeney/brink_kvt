// Navigation sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const navControl = document.getElementById('sidebar-control');
    const sidebar = document.getElementById('sidebarMenu');
    const showSidebarBtn = document.getElementById('showSidebarBtn');

    if (showSidebarBtn) {
        showSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('d-none');
        });
    }

    if (navControl) {
        navControl.addEventListener('click', function() {
            sidebar.classList.add('d-none');
        });
    }
});
