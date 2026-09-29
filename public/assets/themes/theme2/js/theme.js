// Theme 2 — Midnight: mouse-tracking glow + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    var glow = document.getElementById('cursorGlow');
    if (glow && window.matchMedia('(pointer: fine)').matches) {
        document.addEventListener('mousemove', function (e) {
            glow.style.opacity = '1';
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });
        document.addEventListener('mouseleave', function () { glow.style.opacity = '0'; });
    }

    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && reveals.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { entry.target.classList.add('in'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        reveals.forEach(function (el) { observer.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('in'); });
    }
});
