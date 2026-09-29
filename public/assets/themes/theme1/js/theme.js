// Theme 1 — Classic Professional: scroll reveal, sticky navbar shadow, back-to-top visibility
document.addEventListener('DOMContentLoaded', function () {
    var navbar = document.querySelector('.navbar');
    var backToTop = document.querySelector('.back-to-top');

    function onScroll() {
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 10);
        if (backToTop) backToTop.classList.toggle('show', window.scrollY > 400);
    }
    window.addEventListener('scroll', onScroll);
    onScroll();

    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && reveals.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        reveals.forEach(function (el) { observer.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('in'); });
    }
});
