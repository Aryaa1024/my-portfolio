// Theme 4 — Neo-Brutalist: tilt-on-hover cards + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(pointer: fine)').matches) {
        document.querySelectorAll('.tilt-card').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var r = card.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width - 0.5;
                var y = (e.clientY - r.top) / r.height - 0.5;
                card.style.transform = 'rotate(' + (x * 3) + 'deg) translate(' + (-x * 4) + 'px,' + (-y * 4) + 'px)';
            });
            card.addEventListener('mouseleave', function () { card.style.transform = ''; });
        });
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
