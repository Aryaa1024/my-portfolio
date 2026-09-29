@extends('website.themes.theme5.layouts.app')

@section('title', 'Experience | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-4">Work Experience</h1>

        <div class="timeline mb-5">
            @forelse($experiences as $experience)
                <div class="card border-0 shadow-sm mb-3 p-4">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $experience->role }}</h5>
                            <p class="text-primary mb-1">{{ $experience->company }}</p>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary align-self-start">
                            {{ \Illuminate\Support\Str::of($experience->employment_type)->replace('_', ' ')->title() }}
                        </span>
                    </div>
                    <small class="text-muted mb-2 d-block">
                        {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }}
                        &mdash;
                        {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                    </small>
                    <p class="text-muted small mb-0">{{ $experience->description }}</p>
                </div>
            @empty
                <p class="text-muted">No experience added yet.</p>
            @endforelse
        </div>

        <h2 class="fw-bold mb-4">Education</h2>
        <div class="row g-4">
            @forelse($qualifications as $qualification)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-1">{{ $qualification->course_name }}</h5>
                        <p class="text-primary mb-1">{{ $qualification->board_or_university }}</p>
                        <p class="text-muted mb-1">{{ $qualification->college }}</p>
                        <small class="text-muted d-block mb-2">{{ $qualification->course_start }} &mdash; {{ $qualification->course_end }}</small>
                        <span class="badge bg-primary-subtle text-primary align-self-start">
                            {{ ucfirst($qualification->type) }}: {{ $qualification->type_value }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-muted">No qualifications added yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
