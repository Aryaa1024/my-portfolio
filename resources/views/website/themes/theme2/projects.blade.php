@extends('website.themes.theme2.layouts.app')

@section('title', 'Projects | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">All Projects</h1>

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('portfolio.project.show', $project->slug) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            @php $firstImage = is_array($project->images) ? ($project->images[0] ?? null) : null; @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" style="height:200px;object-fit:cover;" alt="{{ $project->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="fw-bold">{{ $project->title }}</h5>
                                <p class="text-light small mb-0">{{ Str::limit($project->excerpt, 100) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-light">No projects added yet.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $projects->links() }}
        </div>
    </div>
</section>
@endsection
