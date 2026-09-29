@extends('website.themes.theme9.layouts.app')

@section('title', 'Contact | ' . ($settings->site_title ?? 'Portfolio'))

@section('content')
<section class="py-5">
    <div class="container" style="max-width: 700px;">
        <h1 class="fw-bold mb-4 text-center">Get In Touch</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('portfolio.contact.store') }}" class="card border-0 shadow-sm p-4">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile (optional)</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror">
                @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4">Send Message</button>
        </form>
    </div>
</section>
@endsection
