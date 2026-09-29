// Theme 7 — Aurora Gradient: magnetic button hover + scroll reveal
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(pointer: fine)').matches) {
        document.querySelectorAll('.magnetic').forEach(function (btn) {
            btn.addEventListener('mousemove', function (e) {
                var r = btn.getBoundingClientRect();
                var x = e.clientX - r.left - r.width / 2;
                var y = e.clientY - r.top - r.height / 2;
                btn.style.transform = 'translate(' + (x * 0.25) + 'px,' + (y * 0.25) + 'px)';
            });
            btn.addEventListener('mouseleave', function () { btn.style.transform = ''; });
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
