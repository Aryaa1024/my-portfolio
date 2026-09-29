<nav id="top" class="navbar navbar-expand-lg sticky-top py-3 glass-nav">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('portfolio.home') }}">
            @if(!empty($settings->light_logo))<img src="{{ asset('storage/' . $settings->light_logo) }}" alt="logo" height="36">@else {{ $settings->site_title ?? 'MyPortfolio' }} @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav gap-lg-2 align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.projects') }}">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.experience') }}">Experience</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.blogs') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.testimonials') }}">Testimonials</a></li>
                <li class="nav-item"><a class="btn btn-primary rounded-pill px-4 ms-lg-2" href="{{ route('portfolio.contact') }}">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
