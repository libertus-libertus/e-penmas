// AOS Initialization
AOS.init({
    once: true, // Animasi hanya terjadi sekali saat di-scroll ke bawah
    mirror: false, // Elemen tidak menganimasikan keluar saat di-scroll ke atas
    duration: 800, // Durasi animasi
    easing: 'ease-in-out', // Easing untuk animasi
});

// Script untuk toggle sidebar
document.addEventListener('DOMContentLoaded', function() {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebarToggleDesktop = document.getElementById('sidebarToggleDesktop');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    }

    if (sidebarToggleDesktop) {
        sidebarToggleDesktop.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    }

    // Current Date & Time for Navbar
    function updateDateTime() {
        const dateTimeElement = document.getElementById('currentDateTime');
        if (dateTimeElement) {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            dateTimeElement.textContent = now.toLocaleDateString('id-ID', options);
        }
    }
    updateDateTime(); // Call once immediately
    setInterval(updateDateTime, 1000); // Update every second
});