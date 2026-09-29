// Theme 6 — Minimal Mono: top scroll-progress bar + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    var bar = document.getElementById('scrollProgress');
    function updateBar() {
        var h = document.documentElement;
        var pct = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
        if (bar) bar.style.width = pct + '%';
    }
    window.addEventListener('scroll', updateBar);
    updateBar();

    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && reveals.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { entry.target.classList.add('in'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.1 });
        reveals.forEach(function (el) { observer.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('in'); });
    }
});
