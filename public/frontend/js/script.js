AOS.init({
    once: true,
    mirror: false,
    duration: 1000,
    easing: 'ease-in-out',
});

// Smooth scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Auto-rotate carousel every 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = document.querySelector('#puskesmasCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
        wrap: true
    });
});