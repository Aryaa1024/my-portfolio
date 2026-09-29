// Theme 9 — Cyberpunk: periodic glitch burst on hero heading + neon cursor + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    var glitchEl = document.querySelector('.glitch');
    if (glitchEl) {
        setInterval(function () {
            glitchEl.classList.add('glitching');
            setTimeout(function () { glitchEl.classList.remove('glitching'); }, 180);
        }, 3200);
    }

    var cursor = document.getElementById('neonCursor');
    if (cursor && window.matchMedia('(pointer: fine)').matches) {
        document.addEventListener('mousemove', function (e) {
            cursor.style.opacity = '1';
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });
        document.addEventListener('mouseleave', function () { cursor.style.opacity = '0'; });
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
