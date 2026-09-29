@extends('admin.layouts.app')

@push('page-style')
    <style>
        .img-preview-box {
            width: 100%;
            height: 120px;
            border: 2px dashed #dee2e6;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            overflow: hidden;
            position: relative;
        }

        .img-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Dark background check for white logos */
        .bg-dark-preview {
            background-color: #212529 !important;
            border-color: #495057 !important;
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">General Settings</h3>
        </div>
    </div>

    <!-- Alert Banner -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none shadow-sm" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form id="settingForm" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row g-4">

                    <!-- Site Identity Info -->
                    <div class="col-md-12">
                        <h5 class="fw-bold text-primary mb-3">Site Identity</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="site_title" class="form-label fw-semibold">Site Title</label>
                        <input type="text" class="form-control" name="site_title" id="site_title"
                            value="{{ $setting->site_title }}" placeholder="e.g. My Portfolio">
                        <div class="invalid-feedback error-site_title"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="site_description" class="form-label fw-semibold">Site Description / SEO Meta</label>
                        <textarea class="form-control" name="site_description" id="site_description" rows="3"
                            placeholder="Brief description of the website...">{{ $setting->site_description }}</textarea>
                        <div class="invalid-feedback error-site_description"></div>
                    </div>

                    <!-- Media Assets -->
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">Branding Assets</h5>
                    </div>

                    <!-- Light Logo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Light Logo (For Dark Backgrounds)</label>
                        <div class="img-preview-box bg-dark-preview mb-2" id="preview-box-light_logo">
                            @if ($setting->light_logo)
                                <img src="{{ asset('storage/' . $setting->light_logo) }}" id="preview-light_logo">
                            @else
                                <span class="text-white-50"><i class="bi bi-image fs-1"></i></span>
                                <img src="" id="preview-light_logo" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input" data-target="light_logo"
                            name="light_logo" accept="image/*">
                        <div class="invalid-feedback error-light_logo"></div>
                    </div>

                    <!-- Dark Logo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Dark Logo (For Light Backgrounds)</label>
                        <div class="img-preview-box mb-2" id="preview-box-dark_logo">
                            @if ($setting->dark_logo)
                                <img src="{{ asset('storage/' . $setting->dark_logo) }}" id="preview-dark_logo">
                            @else
                                <span class="text-muted"><i class="bi bi-image fs-1"></i></span>
                                <img src="" id="preview-dark_logo" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input" data-target="dark_logo"
                            name="dark_logo" accept="image/*">
                        <div class="invalid-feedback error-dark_logo"></div>
                    </div>

                    <!-- Light Favicon -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Favicon Light (16x16 or 32x32)</label>
                        <div class="img-preview-box bg-dark-preview mb-2" id="preview-box-light_favicon"
                            style="height: 80px;">
                            @if ($setting->light_favicon)
                                <img src="{{ asset('storage/' . $setting->light_favicon) }}" id="preview-light_favicon">
                            @else
                                <span class="text-white-50"><i class="bi bi-app-indicator fs-3"></i></span>
                                <img src="" id="preview-light_favicon" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input"
                            data-target="light_favicon" name="light_favicon" accept="image/*,.ico">
                        <div class="invalid-feedback error-light_favicon"></div>
                    </div>

                    <!-- Dark Favicon -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Favicon Dark (16x16 or 32x32)</label>
                        <div class="img-preview-box mb-2" id="preview-box-dark_favicon" style="height: 80px;">
                            @if ($setting->dark_favicon)
                                <img src="{{ asset('storage/' . $setting->dark_favicon) }}" id="preview-dark_favicon">
                            @else
                                <span class="text-muted"><i class="bi bi-app-indicator fs-3"></i></span>
                                <img src="" id="preview-dark_favicon" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input"
                            data-target="dark_favicon" name="dark_favicon" accept="image/*,.ico">
                        <div class="invalid-feedback error-dark_favicon"></div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4 shadow-sm">
                            <span id="saveBtnText">Save Settings</span>
                            <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <!-- Decorative Card Corners -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
    </div>
@endsection

@push('page-script')
    <script>
        $(document).ready(function() {
            // Live Image Preview Logic
            $(document).on('change', '.img-upload-input', function() {
                const target = $(this).data('target');
                const file = this.files[0];
                const previewImg = $(`#preview-${target}`);
                const placeholder = $(`#preview-box-${target}`).find('span');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.attr('src', e.target.result).show();
                        placeholder.hide();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Form Validation and AJAX Submit
            $('#settingForm').validate({
                rules: {
                    site_title: {
                        maxlength: 255
                    },
                    site_description: {
                        maxlength: 1000
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    $('.is-invalid').removeClass('is-invalid');

                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.setting') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#saveBtn').prop('disabled', true);
                            $('#saveBtnText').text('Saving...');
                            $('#saveBtnSpinner').removeClass('d-none');
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#ajaxAlertMessage').text(response.message);
                                $('#ajaxAlert').removeClass('d-none alert-danger').addClass(
                                    'alert-success');

                                // Reset button state
                                $('#saveBtn').prop('disabled', false);
                                $('#saveBtnText').text('Save Settings');
                                $('#saveBtnSpinner').addClass('d-none');

                                // Scroll to top to see alert
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 'fast');
                            }
                        },
                        error: function(xhr) {
                            $('#saveBtn').prop('disabled', false);
                            $('#saveBtnText').text('Save Settings');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const inputElement = $(`[name="${fieldKey}"]`);
                                    inputElement.addClass('is-invalid');
                                    $(`.error-${fieldKey}`).text(messages[0])
                                .show();
                                });
                                $('#ajaxAlertMessage').text(
                                    'Please check the highlighted fields.');
                            } else {
                                $('#ajaxAlertMessage').text(
                                    'An unexpected error occurred. Please try again.');
                            }
                            $('#ajaxAlert').removeClass('d-none alert-success').addClass(
                                'alert-danger');
                            $('html, body').animate({
                                scrollTop: 0
                            }, 'fast');
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
