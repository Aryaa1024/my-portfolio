@extends('website.themes.theme10.layouts.app')

@section('title', $blog->title . ' | ' . ($settings->site_title ?? 'Portfolio'))
@section('meta_description', Str::limit($blog->excerpt, 155))

@section('content')
<section class="py-5">
    <div class="container" style="max-width: 800px;">
        <a href="{{ route('portfolio.blogs') }}" class="text-decoration-none small"><i class="bi bi-arrow-left"></i> Back to Blog</a>

        <h1 class="fw-bold mt-3 mb-2">{{ $blog->title }}</h1>
        <small class="text-muted">{{ optional($blog->published_at)->format('M d, Y') }}</small>

        @if($blog->featured_image)
            <img src="{{ asset('storage/' . $blog->featured_image) }}" class="img-fluid rounded-4 w-100 my-4" style="max-height:420px;object-fit:cover;" alt="{{ $blog->title }}">
        @endif

        <div class="content">
            {!! $blog->description !!}
        </div>
    </div>
</section>
@endsection
