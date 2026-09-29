@extends('website.themes.theme4.layouts.app')

@section('title', $project->title . ' | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <a href="{{ route('portfolio.projects') }}" class="text-decoration-none small"><i class="bi bi-arrow-left"></i> Back to Projects</a>

        <h1 class="fw-bold mt-3 mb-2">{{ $project->title }}</h1>
        <p class="text-muted mb-4">{{ $project->excerpt }}</p>

        @if(!empty($project->live_url))
            <a href="{{ $project->live_url }}" target="_blank" class="btn btn-primary rounded-pill mb-4">
                <i class="bi bi-box-arrow-up-right me-1"></i> Visit Live Site
            </a>
        @endif

        @if(is_array($project->images) && count($project->images))
            <div class="splide mb-4" data-per-page="1" data-pagination="true">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($project->images as $img)
                            <li class="splide__slide">
                                <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded-4 w-100" style="max-height:480px;object-fit:cover;" alt="{{ $project->title }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="content">
            {!! $project->description !!}
        </div>
    </div>
</section>
@endsection
