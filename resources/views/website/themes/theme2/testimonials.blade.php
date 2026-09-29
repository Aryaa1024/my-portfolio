@extends('website.themes.theme2.layouts.app')

@section('title', 'Testimonials | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Testimonials</h1>

        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        @if($testimonial->user_image)
                            <img src="{{ asset('storage/' . $testimonial->user_image) }}" class="rounded-circle mx-auto mb-3" width="70" height="70" style="object-fit:cover;" alt="{{ $testimonial->name }}">
                        @endif
                        <div class="mb-2 text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="text-light small">"{{ $testimonial->comment }}"</p>
                        <h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6>
                    </div>
                </div>
            @empty
                <p class="text-light">No testimonials yet.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    </div>
</section>
@endsection
