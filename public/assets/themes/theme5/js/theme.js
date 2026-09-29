// Theme 5 — Glassmorphism: mouse-parallax gradient blobs + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    var blobs = document.querySelectorAll('.blob');
    if (blobs.length && window.matchMedia('(pointer: fine)').matches) {
        document.addEventListener('mousemove', function (e) {
            var x = (e.clientX / window.innerWidth - 0.5) * 2;
            var y = (e.clientY / window.innerHeight - 0.5) * 2;
            blobs.forEach(function (blob, i) {
                var strength = (i + 1) * 12;
                blob.style.transform = 'translate(' + (x * strength) + 'px,' + (y * strength) + 'px)';
            });
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
