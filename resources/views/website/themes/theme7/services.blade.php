@extends('website.themes.theme7.layouts.app')

@section('title', 'Services | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Services</h1>

        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        @if($service->icon)
                            <i class="{{ $service->icon }} fs-2 text-primary mb-3"></i>
                        @endif
                        <h5 class="fw-bold">{{ $service->title }}</h5>
                        <p class="text-muted small mb-0">{{ $service->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">No services added yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
