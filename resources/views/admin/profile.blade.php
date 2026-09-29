@extends('admin.layouts.app')

@push('page-style')
    <style>
        .profile-img-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
            cursor: pointer;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-img-container:hover .profile-img-overlay {
            opacity: 1;
        }

        /* Error Styles for jQuery Validation */
        label.error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        input.error, select.error, textarea.error {
            border-color: #dc3545 !important;
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Profile</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-3 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3">My Profile</h3>
        </div>
    </div>

    <!-- Alert Banner -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Profile Image Section (AJAX Upload) -->
                <div class="col-md-3 col-lg-3 text-center mb-3">
                    <div class="profile-img-container rounded-circle overflow-hidden shadow-sm"
                        onclick="$('#profile_pic_input').click();">
                        <img class="img-fluid profile-img" id="profileImagePreview"
                            src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/img/user/profile.jpg') }}"
                            alt="Profile Picture">
                        <div class="profile-img-overlay text-white">
                            <i class="bi bi-camera-fill fs-3 mb-1"></i>
                            <span class="small fw-bold">Change Photo</span>
                        </div>
                    </div>
                    <input type="file" id="profile_pic_input" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <div id="profilePicError" class="small mt-2 fw-semibold"></div>
                </div>

                <!-- Profile Form Section -->
                <div class="col-md-9">
                    <form id="profileForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                <div class="invalid-feedback error-name"></div>
                            </div>

                            <!-- Job Title -->
                            <div class="col-md-6 mb-3">
                                <label for="job_title" class="form-label fw-semibold">Job Title: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="job_title" id="job_title" value="{{ $user->profile?->title }}">
                                <div class="invalid-feedback error-job_title"></div>
                            </div>

                            <!-- Personal Mobile -->
                            <div class="col-md-6 mb-3">
                                <label for="personal_mobile_number" class="form-label fw-semibold">Personal Mobile: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="personal_mobile_code" id="personal_mobile_code" class="form-select w-25">
                                        <option value="+91" {{ $user->mobile_code == '+91' ? 'selected' : '' }}>+91</option>
                                    </select>
                                    <input type="tel" class="form-control w-75" id="personal_mobile_number"
                                        name="personal_mobile_number" inputmode="numeric" maxlength="15"
                                        value="{{ $user->mobile_number }}" placeholder="Enter mobile number">
                                </div>
                                <div class="invalid-feedback error-personal_mobile_number"></div>
                            </div>

                            <!-- Professional Mobile -->
                            <div class="col-md-6 mb-3">
                                <label for="pro_mobile_number" class="form-label fw-semibold">Professional Mobile:</label>
                                <div class="input-group">
                                    <select name="pro_mobile_code" id="pro_mobile_code" class="form-select w-25">
                                        <option value="+91" {{ $user->profile?->official_mobile_code == '+91' ? 'selected' : '' }}>+91</option>
                                    </select>
                                    <input type="tel" class="form-control w-75" id="pro_mobile_number"
                                        name="pro_mobile_number" inputmode="numeric" maxlength="15"
                                        value="{{ $user->profile?->official_mobile_number }}" placeholder="Enter mobile number">
                                </div>
                                <div class="invalid-feedback error-pro_mobile_number"></div>
                            </div>

                            <!-- Personal Email -->
                            <div class="col-md-6 mb-3">
                                <label for="personal_email" class="form-label fw-semibold">Personal Email: <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="personal_email" id="personal_email" value="{{ $user->email }}">
                                <div class="invalid-feedback error-personal_email"></div>
                            </div>

                            <!-- Professional Email -->
                            <div class="col-md-6 mb-3">
                                <label for="pro_email" class="form-label fw-semibold">Professional Email:</label>
                                <input type="email" class="form-control" name="pro_email" id="pro_email" value="{{ $user->profile?->official_email }}">
                                <div class="invalid-feedback error-pro_email"></div>
                            </div>

                            <!-- Excerpt / Aim -->
                            <div class="col-md-12 mb-3">
                                <label for="excerpt" class="form-label fw-semibold">Aim:</label>
                                <textarea name="excerpt" id="excerpt" rows="2" class="form-control">{{ $user->profile?->excerpt }}</textarea>
                                <div class="invalid-feedback error-excerpt"></div>
                            </div>

                            <!-- Description / Summary -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label fw-semibold">Summary:</label>
                                <textarea name="description" id="description" rows="4" class="form-control">{{ $user->profile?->description }}</textarea>
                                <div class="invalid-feedback error-description"></div>
                            </div>

                            <!-- Social Links -->
                            <div class="col-md-6 mb-3">
                                <label for="linkedin_url" class="form-label fw-semibold">LinkedIn URL:</label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ $user->profile?->linkedin_url }}" placeholder="https://linkedin.com/in/username">
                                <div class="invalid-feedback error-linkedin_url"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="github_url" class="form-label fw-semibold">Github URL:</label>
                                <input type="url" class="form-control" id="github_url" name="github_url" value="{{ $user->profile?->github_url }}" placeholder="https://github.com/username">
                                <div class="invalid-feedback error-github_url"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="facebook_url" class="form-label fw-semibold">Facebook URL:</label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ $user->profile?->facebook_url }}" placeholder="https://facebook.com/username">
                                <div class="invalid-feedback error-facebook_url"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="instagram_url" class="form-label fw-semibold">Instagram URL:</label>
                                <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ $user->profile?->instagram_url }}" placeholder="https://instagram.com/username">
                                <div class="invalid-feedback error-instagram_url"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="x_url" class="form-label fw-semibold">X URL:</label>
                                <input type="url" class="form-control" id="x_url" name="x_url" value="{{ $user->profile?->x_url }}" placeholder="https://x.com/username">
                                <div class="invalid-feedback error-x_url"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="youtube_url" class="form-label fw-semibold">Youtube URL:</label>
                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ $user->profile?->youtube_url }}" placeholder="https://youtube.com/username">
                                <div class="invalid-feedback error-youtube_url"></div>
                            </div>

                            <!-- Resume File Section -->
                            <div class="col-md-12 mb-3">
                                <label for="resume_file" class="form-label fw-semibold">Resume/CV: <span class="text-muted small">(Max: 300KB, PDF Only)</span></label>
                                <input type="file" class="form-control" name="resume_file" id="resume_file" accept="application/pdf">
                                <div class="invalid-feedback error-resume_file"></div>
                                
                                <!-- Preview Resume File -->
                                <div id="resumeFilePreview" class="mt-2">
                                    @if ($user->profile?->resume_file)
                                        <a href="{{ asset('storage/' . $user->profile->resume_file) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2 shadow-sm">
                                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> View Current Resume
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Hero Image Section -->
                            <div class="col-md-12 mb-3">
                                <label for="hero_image" class="form-label fw-semibold">Hero Image: <span class="text-muted small">(Max: 300KB, JPG, JPEG, PNG, WEBP)</span></label>
                                <input type="file" class="form-control" id="hero_image" name="hero_image" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <div class="invalid-feedback error-hero_image"></div>
                                
                                <!-- Preview Hero Image -->
                                <div id="heroImagePreview" class="mt-2">
                                    @if ($user->profile?->hero_image)
                                        <img src="{{ asset('storage/' . $user->profile->hero_image) }}" alt="Hero Image" class="img-thumbnail shadow-sm" style="max-height: 120px;">
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" id="submitBtn" class="btn btn-primary px-4">
                                    <span id="btnText">Save Changes</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

            // -------------------------------------------------------------
            // 1. CLIENT-SIDE PREVIEW FOR HERO IMAGE & RESUME
            // -------------------------------------------------------------

            // Hero Image Preview
            $('#hero_image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#heroImagePreview').html(`
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${e.target.result}" class="img-thumbnail shadow-sm" style="max-height: 120px;" />
                                    <span class="badge bg-info text-dark">New Preview</span>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Resume File Preview
            $('#resume_file').on('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.type === 'application/pdf') {
                        const fileUrl = URL.createObjectURL(file);
                        $('#resumeFilePreview').html(`
                            <div class="d-flex align-items-center gap-2">
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success shadow-sm">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Preview Selected PDF (${(file.size / 1024).toFixed(1)} KB)
                                </a>
                                <span class="badge bg-info text-dark">New Preview</span>
                            </div>
                        `);
                    }
                }
            });

            // -------------------------------------------------------------
            // 2. PROFILE PICTURE AJAX UPLOAD
            // -------------------------------------------------------------
            const previousPicUrl = $('#profileImagePreview').attr('src');
            
            $('#profile_pic_input').on('change', function() {
                const file = this.files[0];
                $('#profilePicError').text('');
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);

                const formData = new FormData();
                formData.append('profile_image', file);
                formData.append('formType', 'profile_image');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('admin.profile') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#profilePicError').removeClass('text-danger text-success').addClass('text-info').text('Uploading...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#profilePicError').removeClass('text-info').addClass('text-success').text(response.message);
                            $('#profileImagePreview').attr('src', response.image_url);
                        }
                        window.location.reload();
                    },
                    error: function(xhr) {
                        $('#profileImagePreview').attr('src', previousPicUrl);
                        $('#profilePicError').removeClass('text-info text-success').addClass('text-danger');

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('#profilePicError').text(errors.profile_pic ? errors.profile_pic[0] : 'Validation failed.');
                        } else {
                            $('#profilePicError').text('Failed to upload image. Please try again.');
                        }
                    }
                });
            });

            // -------------------------------------------------------------
            // 3. JQUERY VALIDATOR CUSTOM METHODS
            // -------------------------------------------------------------

            // Max file size validator method (bytes)
            $.validator.addMethod('maxSize', function(value, element, param) {
                return this.optional(element) || (element.files[0] && element.files[0].size <= param);
            }, function(param, element) {
                return `File size must be less than ${(param / 1024).toFixed(0)} KB`;
            });

            // File extension validator method
            $.validator.addMethod('acceptExt', function(value, element, param) {
                if (this.optional(element) || !element.files[0]) return true;
                const ext = element.files[0].name.split('.').pop().toLowerCase();
                return param.split(',').includes(ext);
            }, 'Invalid file type.');

            // -------------------------------------------------------------
            // 4. JQUERY FORM VALIDATION & AJAX SUBMISSION
            // -------------------------------------------------------------
            $('#profileForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    job_title: {
                        required: true,
                        maxlength: 255
                    },
                    personal_email: {
                        required: true,
                        email: true
                    },
                    personal_mobile_number: {
                        required: true,
                        digits: true,
                        maxlength: 15
                    },
                    pro_email: {
                        email: true
                    },
                    pro_mobile_number: {
                        digits: true,
                        maxlength: 15
                    },
                    linkedin_url: { url: true },
                    github_url: { url: true },
                    facebook_url: { url: true },
                    instagram_url: { url: true },
                    x_url: { url: true },
                    youtube_url: { url: true },
                    resume_file: {
                        acceptExt: 'pdf',
                        maxSize: 307200 // 300 KB
                    },
                    hero_image: {
                        acceptExt: 'jpg,jpeg,png,webp',
                        maxSize: 307200 // 300 KB
                    }
                },
                messages: {
                    name: { required: "Please enter your name." },
                    job_title: { required: "Please enter your job title." },
                    personal_email: {
                        required: "Personal email is required.",
                        email: "Enter a valid email address."
                    },
                    personal_mobile_number: {
                        required: "Personal mobile number is required.",
                        digits: "Digits only."
                    },
                    resume_file: {
                        acceptExt: "Only PDF files are allowed.",
                        maxSize: "Resume file size must not exceed 300KB."
                    },
                    hero_image: {
                        acceptExt: "Only JPG, JPEG, PNG, or WEBP images are allowed.",
                        maxSize: "Hero image size must not exceed 300KB."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    if (element.closest('.input-group').length) {
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // Clear previous field errors and alerts
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');$('#ajaxAlert').addClass('d-none');

                    const formData = new FormData(form);
                    formData.append('_token','{{ csrf_token() }}')

                    $.ajax({
                        url: "{{ route('admin.profile') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#submitBtn').prop('disabled', true);
                            $('#btnText').text('Saving...');
                            $('#btnSpinner').removeClass('d-none');
                        },
                        success: function(response) {
                            $('#submitBtn').prop('disabled', false);
                            $('#btnText').text('Save Changes');
                            $('#btnSpinner').addClass('d-none');

                            if (response.success) {
                                $('#ajaxAlertMessage').text(response.message);
                                $('#ajaxAlert').removeClass('d-none alert-danger').addClass('alert-success');

                                // Update current view previews if new files returned
                                if (response.data.hero_image_url) {
                                    $('#heroImagePreview').html(`
                                        <img src="${response.data.hero_image_url}" class="img-thumbnail shadow-sm" style="max-height: 120px;" />
                                    `);
                                }
                                if (response.data.resume_file_url) {
                                    $('#resumeFilePreview').html(`
                                        <a href="${response.data.resume_file_url}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm">
                                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> View Current Resume
                                        </a>
                                    `);
                                }
                                window.location.reload();
                            }
                        },
                        error: function(xhr) {
                            $('#submitBtn').prop('disabled', false);
                            $('#btnText').text('Save Changes');
                            $('#btnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(field, messages) {
                                    const input = $(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    $(`.error-${field}`).text(messages[0]);
                                });

                                $('#ajaxAlertMessage').text('Please correct the highlighted errors above.');
                                $('#ajaxAlert').removeClass('d-none alert-success').addClass('alert-danger');
                            } else {
                                $('#ajaxAlertMessage').text('An unexpected error occurred. Please try again.');
                                $('#ajaxAlert').removeClass('d-none alert-success').addClass('alert-danger');
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush