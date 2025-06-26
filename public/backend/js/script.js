AOS.init({
    once: true,
    mirror: false,
    duration: 800,
    easing: 'ease-in-out',
});

// Script untuk toggle sidebar
document.getElementById('sidebarCollapse').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('content').classList.toggle('active');
});

document.getElementById('sidebarToggleDesktop').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('content').classList.toggle('active');
});

// Current Date & Time
function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
}
updateDateTime();
setInterval(updateDateTime, 1000);