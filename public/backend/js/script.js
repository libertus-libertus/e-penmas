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

    // Global SweetAlert2 (for delete confirmation)
    // Make sure SweetAlert2 is loaded via CDN or NPM in your layout or specific page
    window.confirmDelete = function(formId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
});