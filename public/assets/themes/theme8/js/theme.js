// Theme 8 — Retro Paper: typewriter effect on hero role text + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('typewriter');
    if (el) {
        var text = el.getAttribute('data-text') || '';
        el.textContent = '';
        var i = 0;
        (function type() {
            if (i <= text.length) {
                el.textContent = text.slice(0, i);
                i++;
                setTimeout(type, 45);
            }
        })();
    }

    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && reveals.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { entry.target.classList.add('in'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        reveals.forEach(function (el2) { observer.observe(el2); });
    } else {
        reveals.forEach(function (el2) { el2.classList.add('in'); });
    }
});
