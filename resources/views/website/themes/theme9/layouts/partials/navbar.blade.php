<nav id="top" class="navbar navbar-expand-lg sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 orbitron neon-text" href="{{ route('portfolio.home') }}">
            @if(!empty($settings->light_logo))<img src="{{ asset('storage/' . $settings->light_logo) }}" alt="logo" height="36">@else {{ $settings->site_title ?? 'MyPortfolio' }} @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav gap-lg-2 align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.home') }}">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.projects') }}">PROJECTS</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.services') }}">SERVICES</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.experience') }}">EXPERIENCE</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.blogs') }}">BLOG</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('portfolio.testimonials') }}">TESTIMONIALS</a></li>
                <li class="nav-item"><a class="btn btn-primary px-4 ms-lg-2" href="{{ route('portfolio.contact') }}">CONTACT</a></li>
            </ul>
        </div>
    </div>
</nav>
