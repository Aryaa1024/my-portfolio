@extends('website.themes.theme2.layouts.app')

@section('title', 'Blog | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Blog</h1>

        <div class="row g-4">
            @forelse($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('portfolio.blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $blog->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="fw-bold">{{ $blog->title }}</h5>
                                <p class="text-light small mb-0">{{ Str::limit($blog->excerpt, 100) }}</p>
                                <small class="text-light">{{ optional($blog->published_at)->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-light">No blog posts yet.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
</section>
@endsection
