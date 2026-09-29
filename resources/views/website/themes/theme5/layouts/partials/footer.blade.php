<footer class="site-footer pt-5 pb-4 mt-5">
    <div class="container">
        <div class="glass-panel p-4 p-lg-5">
        <div class="row gy-4">
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">{{ $settings->site_title ?? 'Portfolio' }}</h5>
                <p class="opacity-75">{{ $settings->site_description ?? ($user->profile->excerpt ?? '') }}</p>
                <div class="d-flex gap-3 fs-5 mt-3">
                    @isset($user->profile->linkedin_url)@if($user->profile->linkedin_url)<a class="social-btn" href="{{ $user->profile->linkedin_url }}" target="_blank"><i class="bi bi-linkedin"></i></a>@endif @endisset
                    @isset($user->profile->github_url)@if($user->profile->github_url)<a class="social-btn" href="{{ $user->profile->github_url }}" target="_blank"><i class="bi bi-github"></i></a>@endif @endisset
                    @isset($user->profile->x_url)@if($user->profile->x_url)<a class="social-btn" href="{{ $user->profile->x_url }}" target="_blank"><i class="bi bi-twitter-x"></i></a>@endif @endisset
                    @isset($user->profile->facebook_url)@if($user->profile->facebook_url)<a class="social-btn" href="{{ $user->profile->facebook_url }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif @endisset
                    @isset($user->profile->youtube_url)@if($user->profile->youtube_url)<a class="social-btn" href="{{ $user->profile->youtube_url }}" target="_blank"><i class="bi bi-youtube"></i></a>@endif @endisset
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('portfolio.projects') }}">Projects</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio.services') }}">Services</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio.blogs') }}">Blog</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio.testimonials') }}">Testimonials</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="fw-bold mb-3">Contact</h6>
                <ul class="list-unstyled small opacity-75">
                    @if(!empty($user->profile->official_email ?? $user->email))<li class="mb-2"><i class="bi bi-envelope me-2"></i>{{ $user->profile->official_email ?? $user->email }}</li>@endif
                    @if(!empty($user->mobile_number))<li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $user->mobile_code }} {{ $user->mobile_number }}</li>@endif
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="fw-bold mb-3">Resume</h6>
                @if(!empty($user->profile->resume_file))<a href="{{ asset('storage/' . $user->profile->resume_file) }}" target="_blank" class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-download me-1"></i> Download CV</a>@endif
            </div>
        </div>
        <hr class="my-4" style="border-color:rgba(255,255,255,.2)">
        <p class="text-center small mb-0 opacity-75">&copy; {{ date('Y') }} {{ $settings->site_title ?? 'Portfolio' }}. All rights reserved.</p>
        </div>
    </div>
</footer>
