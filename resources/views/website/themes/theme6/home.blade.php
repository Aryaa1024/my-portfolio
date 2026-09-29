@extends('website.themes.theme6.layouts.app')

@section('title', ($settings->site_title ?? 'Portfolio') . ' | Home')

@section('content')

<section class="hero py-5 reveal"><div class="container">
    <p class="eyebrow mb-3">Hello, I'm</p>
    <h1 class="mega-title mb-4">{{ $user->name }}</h1>
    <h4 class="mb-4 opacity-75">{{ $user->profile->title ?? '' }}</h4>
    <p class="opacity-75 mb-4 col-lg-7">{{ $user->profile->excerpt ?? '' }}</p>
    <div class="d-flex gap-4">
        <a href="{{ route('portfolio.contact') }}" class="link-underline fw-bold">Hire Me &rarr;</a>
        <a href="{{ route('portfolio.projects') }}" class="link-underline fw-bold">View Work &rarr;</a>
    </div>
    @if(!empty($user->profile->hero_image))
        <img src="{{ asset('storage/' . $user->profile->hero_image) }}" class="img-fluid hero-photo mt-5" alt="{{ $user->name }}">
    @endif
</div></section>

@if($skills->count())
<section class="py-5 reveal border-top"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="section-title mb-0">Skills</h2></div>
    <div class="splide" data-per-page="5" data-per-page-tablet="3"><div class="splide__track"><ul class="splide__list">
        @foreach($skills as $skill)<li class="splide__slide"><div class="card text-center h-100 py-4">@if($skill->icon)<i class="{{ $skill->icon }} fs-1 mb-2"></i>@endif<p class="fw-semibold mb-0">{{ $skill->name }}</p></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($services->count())
<section class="py-5 reveal border-top"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="section-title mb-0">Services</h2><a href="{{ route('portfolio.services') }}" class="link-underline">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($services as $service)<li class="splide__slide"><div class="card h-100 p-4">@if($service->icon)<i class="{{ $service->icon }} fs-2 mb-3"></i>@endif<h5 class="fw-bold">{{ $service->title }}</h5><p class="opacity-75 small">{{ Str::limit($service->description, 100) }}</p></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($projects->count())
<section class="py-5 reveal border-top"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="section-title mb-0">Projects</h2><a href="{{ route('portfolio.projects') }}" class="link-underline">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($projects as $project)<li class="splide__slide"><a href="{{ route('portfolio.project.show', $project->slug) }}" class="text-decoration-none"><div class="card h-100 overflow-hidden">@php $firstImage = is_array($project->images) ? ($project->images[0] ?? null) : null; @endphp @if($firstImage)<img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $project->title }}">@endif<div class="card-body"><h5 class="fw-bold">{{ $project->title }}</h5><p class="opacity-75 small mb-0">{{ Str::limit($project->excerpt, 90) }}</p></div></div></a></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($blogs->count())
<section class="py-5 reveal border-top"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="section-title mb-0">Articles</h2><a href="{{ route('portfolio.blogs') }}" class="link-underline">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2"><div class="splide__track"><ul class="splide__list">
        @foreach($blogs as $blog)<li class="splide__slide"><a href="{{ route('portfolio.blog.show', $blog->slug) }}" class="text-decoration-none"><div class="card h-100 overflow-hidden">@if($blog->featured_image)<img src="{{ asset('storage/' . $blog->featured_image) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $blog->title }}">@endif<div class="card-body"><h5 class="fw-bold">{{ $blog->title }}</h5><p class="opacity-75 small mb-0">{{ Str::limit($blog->excerpt, 90) }}</p></div></div></a></li>@endforeach
    </ul></div></div>
</div></section>
@endif

@if($testimonials->count())
<section class="py-5 reveal border-top"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2 class="section-title mb-0">Clients Say</h2><a href="{{ route('portfolio.testimonials') }}" class="link-underline">View All</a></div>
    <div class="splide" data-per-page="3" data-per-page-tablet="2" data-pagination="true"><div class="splide__track"><ul class="splide__list">
        @foreach($testimonials as $testimonial)<li class="splide__slide"><div class="card h-100 p-4 text-center">@if($testimonial->user_image)<img src="{{ asset('storage/' . $testimonial->user_image) }}" class="rounded-circle mx-auto mb-3" width="70" height="70" style="object-fit:cover;" alt="{{ $testimonial->name }}">@endif<div class="mb-2 text-warning">@for($i = 1; $i <= 5; $i++)<i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>@endfor</div><p class="opacity-75 small">"{{ Str::limit($testimonial->comment, 120) }}"</p><h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6></div></li>@endforeach
    </ul></div></div>
</div></section>
@endif

<section class="py-5 reveal border-top"><div class="container text-center">
    <h2 class="section-title mb-3">Let's Work Together</h2>
    <p class="opacity-75 mb-4">Have a project in mind? I'd love to hear about it.</p>
    <a href="{{ route('portfolio.contact') }}" class="link-underline fw-bold fs-5">Get In Touch &rarr;</a>
</div></section>

@endsection
