@extends('admin.layouts.app')

@push('page-style')
    <style>
        .img-preview-box {
            width: 100%;
            height: 120px;
            border: 1px dashed #dee2e6;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .img-preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .bg-dark-preview {
            background-color: #212529 !important;
            border-color: #495057 !important;
        }

        .theme-table-img {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
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

    <!-- Alert Banner -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none shadow-sm" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- BEGIN: General Settings Section -->
    <div class="row mb-3 d-flex align-items-center justify-content-between">
        <div class="col-sm-12">
            <h3 class="h3 mb-0">General Settings</h3>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="settingForm" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="form_type" value="general_setting">
                <div class="row g-4">
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
                            placeholder="Brief description...">{{ $setting->site_description }}</textarea>
                        <div class="invalid-feedback error-site_description"></div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">Branding Assets</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Light Logo (For Dark Backgrounds)</label>
                        <div class="img-preview-box bg-dark-preview mb-2" id="preview-box-light_logo">
                            @if ($setting->light_logo)
                                <img src="{{ asset('storage/' . $setting->light_logo) }}" id="preview-light_logo">
                            @else
                                <span class="text-white-50"><i class="bi bi-image fs-1"></i></span><img src=""
                                    id="preview-light_logo" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input" data-target="light_logo"
                            name="light_logo" accept="image/*">
                        <div class="invalid-feedback error-light_logo"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Dark Logo (For Light Backgrounds)</label>
                        <div class="img-preview-box mb-2" id="preview-box-dark_logo">
                            @if ($setting->dark_logo)
                                <img src="{{ asset('storage/' . $setting->dark_logo) }}" id="preview-dark_logo">
                            @else
                                <span class="text-muted"><i class="bi bi-image fs-1"></i></span><img src=""
                                    id="preview-dark_logo" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input" data-target="dark_logo"
                            name="dark_logo" accept="image/*">
                        <div class="invalid-feedback error-dark_logo"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Favicon Light</label>
                        <div class="img-preview-box bg-dark-preview mb-2" id="preview-box-light_favicon"
                            style="height: 80px;">
                            @if ($setting->light_favicon)
                                <img src="{{ asset('storage/' . $setting->light_favicon) }}" id="preview-light_favicon">
                            @else
                                <span class="text-white-50"><i class="bi bi-app-indicator fs-3"></i></span><img
                                    src="" id="preview-light_favicon" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input"
                            data-target="light_favicon" name="light_favicon" accept="image/*,.ico">
                        <div class="invalid-feedback error-light_favicon"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Favicon Dark</label>
                        <div class="img-preview-box mb-2" id="preview-box-dark_favicon" style="height: 80px;">
                            @if ($setting->dark_favicon)
                                <img src="{{ asset('storage/' . $setting->dark_favicon) }}" id="preview-dark_favicon">
                            @else
                                <span class="text-muted"><i class="bi bi-app-indicator fs-3"></i></span><img
                                    src="" id="preview-dark_favicon" style="display:none;">
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm img-upload-input"
                            data-target="dark_favicon" name="dark_favicon" accept="image/*,.ico">
                        <div class="invalid-feedback error-dark_favicon"></div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" id="saveSettingBtn" class="btn btn-primary px-4 shadow-sm">
                            <span id="saveSettingBtnText">Save Settings</span>
                            <span id="saveSettingBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
    </div>
    <!-- END: General Settings Section -->

    <!-- BEGIN: Themes Section -->
    <div class="row mb-3 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">Themes</h3>
        </div>
        {{-- <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary shadow-sm" id="addThemeBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Theme
            </button>
        </div> --}}
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Preview</th>
                            <th>Theme Name</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($themes as $key =>$theme)
                            <tr>
                                <td class="ps-4">{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $theme->image ? asset('storage/' . $theme->image) : asset('assets/img/placeholder-theme.jpg') }}"
                                        alt="{{ $theme->name }}" class="theme-table-img shadow-sm">
                                </td>
                                <td><span class="fw-bold">{{ ucfirst($theme->name) }}</span></td>
                                <td>
                                    @if ($theme->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success"><i
                                                class="bi bi-check-circle me-1"></i>Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if (!$theme->is_active)
                                        <button class="btn btn-sm btn-success activate-theme-btn me-1"
                                            data-id="{{ $theme->id }}" title="Activate Theme">
                                            <i class="bi bi-play-circle"></i> Activate
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-primary edit-theme-btn me-1"
                                        data-id="{{ $theme->id }}" data-name="{{ $theme->name }}"
                                        data-image="{{ $theme->image ? asset('storage/' . $theme->image) : '' }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    {{-- <button class="btn btn-sm btn-outline-danger delete-theme-btn"
                                        data-id="{{ $theme->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No themes available. Click "Add
                                    Theme" to create one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
    </div>
    <!-- END: Themes Section -->

    <!-- Theme CRUD Modal -->
    <div class="modal fade" id="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="themeModalLabel">Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="themeCrudForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="theme_modal">
                    <input type="hidden" name="theme_id" id="theme_id">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Theme Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="theme_name"
                                placeholder="e.g. theme1">
                            <div class="invalid-feedback error-theme-name"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Preview Image</label>
                            <div class="img-preview-box mb-2" id="preview-box-theme_image">
                                <span class="text-muted" id="theme-placeholder-icon"><i
                                        class="bi bi-image fs-1"></i></span>
                                <img src="" id="preview-theme_image" style="display:none;">
                            </div>
                            <input type="file" class="form-control form-control-sm img-upload-input"
                                data-target="theme_image" name="image" id="theme_image_input" accept="image/*">
                            <div class="invalid-feedback error-theme-image"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveThemeBtn" class="btn btn-primary px-4">
                            <span id="saveThemeBtnText">Save Theme</span>
                            <span id="saveThemeBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script>
        $(document).ready(function() {
            const themeModal = new bootstrap.Modal(document.getElementById('themeModal'));

            // Live Image Preview Logic
            $(document).on('change', '.img-upload-input', function() {
                const target = $(this).data('target');
                const file = this.files[0];
                const previewImg = $(`#preview-${target}`);
                let placeholder = $(`#preview-box-${target}`).find('span');

                // Special selector for theme modal placeholder
                if (target === 'theme_image') placeholder = $('#theme-placeholder-icon');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.attr('src', e.target.result).show();
                        placeholder.hide();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // --- Theme CRUD AJAX Logic ---

            // Open Modal for Add
            $('#addThemeBtn').on('click', function() {
                $('#themeCrudForm')[0].reset();
                $('#theme_id').val('');

                // Ensure name is editable on Create
                $('#theme_name').prop('readonly', false);

                $('#preview-theme_image').hide().attr('src', '');
                $('#theme-placeholder-icon').show();
                $('#themeModalLabel').text('Add Theme');
                $('.is-invalid').removeClass('is-invalid');
                themeModal.show();
            });

            // Open Modal for Edit
            $('.edit-theme-btn').on('click', function() {
                $('#themeCrudForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');

                const id = $(this).data('id');
                const name = $(this).data('name');
                const image = $(this).data('image');

                $('#theme_id').val(id);
                $('#theme_name').val(name);

                // Disable editing of the name field on Edit
                $('#theme_name').prop('readonly', true);

                if (image) {
                    $('#preview-theme_image').attr('src', image).show();
                    $('#theme-placeholder-icon').hide();
                } else {
                    $('#preview-theme_image').hide().attr('src', '');
                    $('#theme-placeholder-icon').show();
                }

                $('#themeModalLabel').text('Edit Theme');
                themeModal.show();
            });

            // Submit Theme Form (Create/Edit)
            $('#themeCrudForm').validate({
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
                            $('#saveThemeBtn').prop('disabled', true);
                            $('#saveThemeBtnText').text('Saving...');
                            $('#saveThemeBtnSpinner').removeClass('d-none');
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.reload();
                            }
                        },
                        error: function(xhr) {
                            $('#saveThemeBtn').prop('disabled', false);
                            $('#saveThemeBtnText').text('Save Theme');
                            $('#saveThemeBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    if (fieldKey === 'name') {
                                        $('#theme_name').addClass('is-invalid');
                                        $('.error-theme-name').text(messages[0])
                                            .show();
                                    }
                                    if (fieldKey === 'image') {
                                        $('#theme_image_input').addClass(
                                            'is-invalid');
                                        $('.error-theme-image').text(messages[0])
                                            .show();
                                    }
                                });
                            } else {
                                alert('An unexpected error occurred.');
                            }
                        }
                    });
                    return false;
                }
            });

            // Delete Theme
            $('.delete-theme-btn').on('click', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this theme?')) return;

                $.ajax({
                    url: "{{ route('admin.setting') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete_theme',
                        theme_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // Activate Theme
            $('.activate-theme-btn').on('click', function() {
                const id = $(this).data('id');
                if (!confirm('Make this the active theme?')) return;

                $.ajax({
                    url: "{{ route('admin.setting') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'activate_theme',
                        theme_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // --- General Settings Form AJAX Submit ---
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
                            $('#saveSettingBtn').prop('disabled', true);
                            $('#saveSettingBtnText').text('Saving...');
                            $('#saveSettingBtnSpinner').removeClass('d-none');
                        },
                        success: function(response) {
                            $('#saveSettingBtn').prop('disabled', false);
                            $('#saveSettingBtnText').text('Save Settings');
                            $('#saveSettingBtnSpinner').addClass('d-none');

                            if (response.success) {
                                $('#ajaxAlertMessage').text(response.message);
                                $('#ajaxAlert').removeClass('d-none alert-danger').addClass(
                                    'alert-success');
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 'fast');
                            }
                        },
                        error: function(xhr) {
                            $('#saveSettingBtn').prop('disabled', false);
                            $('#saveSettingBtnText').text('Save Settings');
                            $('#saveSettingBtnSpinner').addClass('d-none');

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
