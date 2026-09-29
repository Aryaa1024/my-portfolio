@extends('website.themes.theme8.layouts.app')

@section('title', ($settings->site_title ?? 'Portfolio') . ' | Home')

@section('content')

<section class="hero py-5 reveal"><div class="container">
    <div class="row align-items-center gy-4">
        <div class="col-lg-6">
            <p class="eyebrow mb-2">Hello, I'm</p>
            <h1 class="fw-bold display-4 mb-3 display-font">{{ $user->name }}</h1>
            <h4 class="mb-3 typewriter" id="typewriter" data-text="{{ $user->profile->title ?? '' }}">&nbsp;</h4>
            <p class="opacity-75 mb-4">{{ $user->profile->excerpt ?? '' }}</p>
            <div class="d-flex gap-3">
                <a href="{{ route('portfolio.contact') }}" class="btn btn-primary px-4">Hire Me</a>
                <a href="{{ route('portfolio.projects') }}" class="btn btn-outline-ink px-4">View Work</a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            @if(!empty($user->profile->hero_image))<img src="{{ asset('storage/' . $user->profile->hero_image) }}" class="img-fluid hero-photo" alt="{{ $user->name }}">@endif
        </div>
    </div>
</div></section>

@if($skills->count())
<section class="py-5 bg-alt reveal"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><p class="eyebrow mb-1">What I know</p><h2 class="fw-bold mb-0 display-font">Skills</h2></div></div>
    <div class="splide" data-per-page="5" data-per-page-tablet="3"><div class="splide__track"><ul class="splide__list">
        @foreach($skills as $skill)<li class="splide__slide"><div class="card text-center h-100 py-4">@if($skill->icon)<i class="{{ $skill->icon }} fs-1 mb-2 text-accent"></i>@endif<p class="fw-semibold mb-0">{{ $skill->name }}</p></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($services->count())
<section class="py-5 reveal"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><p class="eyebrow mb-1">How I can help</p><h2 class="fw-bold mb-0 display-font">Services</h2></div><a href="{{ route('portfolio.services') }}" class="btn btn-sm btn-outline-ink">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($services as $service)<li class="splide__slide"><div class="card h-100 p-4">@if($service->icon)<i class="{{ $service->icon }} fs-2 mb-3 text-accent"></i>@endif<h5 class="fw-bold">{{ $service->title }}</h5><p class="opacity-75 small">{{ Str::limit($service->description, 100) }}</p></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($projects->count())
<section class="py-5 bg-alt reveal"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><p class="eyebrow mb-1">Recent work</p><h2 class="fw-bold mb-0 display-font">Latest Projects</h2></div><a href="{{ route('portfolio.projects') }}" class="btn btn-sm btn-outline-ink">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($projects as $project)<li class="splide__slide"><a href="{{ route('portfolio.project.show', $project->slug) }}" class="text-decoration-none"><div class="card h-100 overflow-hidden">@php $firstImage = is_array($project->images) ? ($project->images[0] ?? null) : null; @endphp @if($firstImage)<img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $project->title }}">@endif<div class="card-body"><h5 class="fw-bold">{{ $project->title }}</h5><p class="opacity-75 small mb-0">{{ Str::limit($project->excerpt, 90) }}</p></div></div></a></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($blogs->count())
<section class="py-5 reveal"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><p class="eyebrow mb-1">From the journal</p><h2 class="fw-bold mb-0 display-font">Latest Articles</h2></div><a href="{{ route('portfolio.blogs') }}" class="btn btn-sm btn-outline-ink">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($blogs as $blog)<li class="splide__slide"><a href="{{ route('portfolio.blog.show', $blog->slug) }}" class="text-decoration-none"><div class="card h-100 overflow-hidden">@if($blog->featured_image)<img src="{{ asset('storage/' . $blog->featured_image) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $blog->title }}">@endif<div class="card-body"><span class="badge-accent mb-2 d-inline-block">{{ ucfirst($blog->status) }}</span><h5 class="fw-bold">{{ $blog->title }}</h5><p class="opacity-75 small mb-0">{{ Str::limit($blog->excerpt, 90) }}</p></div></div></a></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($testimonials->count())
<section class="py-5 bg-alt reveal"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><p class="eyebrow mb-1">Kind words</p><h2 class="fw-bold mb-0 display-font">What Clients Say</h2></div><a href="{{ route('portfolio.testimonials') }}" class="btn btn-sm btn-outline-ink">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2" data-pagination="true"><div class="splide__track"><ul class="splide__list">
        @foreach($testimonials as $testimonial)<li class="splide__slide"><div class="card h-100 p-4 text-center">@if($testimonial->user_image)<img src="{{ asset('storage/' . $testimonial->user_image) }}" class="rounded-circle mx-auto mb-3" width="70" height="70" style="object-fit:cover;" alt="{{ $testimonial->name }}">@endif<div class="mb-2 text-warning">@for($i = 1; $i <= 5; $i++)<i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>@endfor</div><p class="opacity-75 small">"{{ Str::limit($testimonial->comment, 120) }}"</p><h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

<section class="py-5 cta-section reveal"><div class="container text-center">
    <h2 class="fw-bold mb-3 display-font">Let's Work Together</h2>
    <p class="opacity-75 mb-4">Have a project in mind? I'd love to hear about it.</p>
    <a href="{{ route('portfolio.contact') }}" class="btn btn-primary px-5 py-2">Get In Touch</a>
</div></section>

@endsection
