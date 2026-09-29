@extends('admin.layouts.app')

@push('page-style')
    <style>
        /* Minimal custom CSS: Only for the star hover animation */
        .star-item {
            cursor: pointer;
            transition: transform 0.1s ease-in-out, color 0.2s;
        }

        .star-item:hover {
            transform: scale(1.15);
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Testimonials</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Testimonials</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addTestimonialsBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Testimonials
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Cards Container -->
    <div class="row" id="testimonialsList">
        @forelse($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4 testimonial-card-wrapper"
                id="testimonial-card-{{ $testimonial->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="border rounded p-1 d-flex align-items-center justify-content-center"
                                    style="width: 46px; height: 46px;">
                                    @if ($testimonial->user_image)
                                        <img src="{{ asset('storage/' . $testimonial->user_image) }}"
                                            alt="{{ $testimonial->name }}" class="object-fit-cover"
                                            style="width: 100%; height: 100%; border-radius: 50%;">
                                    @else
                                        <i class="bi bi-person fs-4 text-primary"></i>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold text-primary mb-0">{{ $testimonial->name }}</h5>
                                    <small class="text-muted">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $testimonial->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted text-opacity-25"></i>
                                            @endif
                                        @endfor
                                    </small>
                                </div>
                            </div>
                            <p class="card-text text-muted small fst-italic mt-2 mb-0">
                                "{{ $testimonial->comment ?? 'No comment provided.' }}"</p>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                            <button class="btn btn-sm btn-outline-primary edit-testimonial-btn"
                                data-id="{{ $testimonial->id }}" data-name="{{ $testimonial->name }}"
                                data-rating="{{ $testimonial->rating }}" data-comment="{{ $testimonial->comment }}"
                                data-image="{{ $testimonial->user_image ? asset('storage/' . $testimonial->user_image) : '' }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-testimonial-btn"
                                data-id="{{ $testimonial->id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                    <!-- Decorative Arrows matched with Skill page -->
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 card" id="noTestimonialsMsg">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No testimonials added yet. Click <strong>"Add Testimonials"</strong> to get started.
                </div>
                <!-- Decorative Arrows matched with Skill page -->
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Bulk Modal -->
    <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimonialModalLabel">Manage Testimonials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Important: enctype for file uploads -->
                <form id="testimonialForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div id="dynamicTestimonialsContainer"></div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success btn-sm" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Testimonial
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save All Testimonials</span>
                            <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
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
            const testimonialModal = new bootstrap.Modal(document.getElementById('testimonialModal'));
            let rowIdx = 0;

            // Default SVG Avatar for Preview Fallback
            const defaultAvatar =
                "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/%3E%3Cpath fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/%3E%3C/svg%3E";

            // Add Validation Rules (Comment is now required)
            $.validator.addClassRules("req-name", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-rating", {
                required: true,
                digits: true,
                min: 1,
                max: 5
            });
            $.validator.addClassRules("req-comment", {
                required: true
            });

            function appendRow(index, data = {}) {
                const name = data.name ? data.name.replace(/"/g, '&quot;') : '';
                const comment = data.comment ? data.comment : '';

                // Set rating to blank string by default to force validation
                const rating = data.rating || '';

                // Use actual image if it exists, otherwise use default SVG
                const imageUrl = data.image ? data.image : defaultAvatar;

                // Generate stars HTML dynamically based on rating
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    const iconClass = (rating && i <= rating) ? 'bi-star-fill text-warning' :
                        'bi-star text-muted text-opacity-25';
                    starsHtml += `<i class="bi ${iconClass} fs-5 star-item" data-val="${i}"></i>`;
                }

                const rowHtml = `
                    <div class="testimonial-row-item card mb-3 position-relative" id="row-item-${index}">
                        <div class="d-flex card-header justify-content-between align-items-center p-2">
                            <h6 class="fw-bold mb-0">Testimonial #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="testimonials[${index}][id]" value="${data.id || ''}">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Client Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm req-name" 
                                        name="testimonials[${index}][name]" value="${name}" placeholder="e.g. John Doe">
                                    <div class="invalid-feedback error-testimonials-${index}-name">Please enter client name.</div>
                                </div>

                                <!-- Interactive Star Rating -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold d-block">Rating <span class="text-danger">*</span></label>
                                    <div class="star-rating-container d-inline-flex gap-1 rounded" data-index="${index}">
                                        ${starsHtml}
                                        <!-- Hidden input holds actual value -->
                                        <input type="hidden" name="testimonials[${index}][rating]" class="req-rating" value="${rating}">
                                    </div>
                                    <div class="invalid-feedback error-testimonials-${index}-rating mt-1" style="display:none;">Please select a rating.</div>
                                </div>

                                <!-- Clean Single Image Preview -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Client Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; flex-shrink: 0;">
                                            <img src="${imageUrl}" id="preview-${index}" class="object-fit-cover" style="width: 100%; height: 100%; border-radius: 50%;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm img-upload-input" data-index="${index}" name="testimonials[${index}][user_image]" accept="image/*">
                                            ${data.id ? '<small class="text-muted d-block mt-1">Leave blank to keep existing image.</small>' : ''}
                                            <div class="invalid-feedback error-testimonials-${index}-user_image">Invalid image format.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comment (Now Required) -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Comment / Feedback <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm req-comment" name="testimonials[${index}][comment]" rows="3" placeholder="Write their feedback here...">${comment}</textarea>
                                    <div class="invalid-feedback error-testimonials-${index}-comment">Please provide a comment.</div>
                                </div>
                            </div>
                        </div>
                        <!-- Decorative Arrows matched with Skill page -->
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                `;
                $('#dynamicTestimonialsContainer').append(rowHtml);
            }

            // --- Star Rating Interactive Logic ---
            $(document).on('mouseenter', '.star-item', function() {
                const val = $(this).data('val');
                const container = $(this).closest('.star-rating-container');

                container.find('.star-item').each(function() {
                    if ($(this).data('val') <= val) {
                        $(this).removeClass('bi-star text-muted text-opacity-25').addClass(
                            'bi-star-fill text-warning');
                    } else {
                        $(this).removeClass('bi-star-fill text-warning').addClass(
                            'bi-star text-muted text-opacity-25');
                    }
                });
            });

            $(document).on('mouseleave', '.star-rating-container', function() {
                const selectedVal = $(this).find('input[type="hidden"]').val();

                $(this).find('.star-item').each(function() {
                    if (selectedVal && $(this).data('val') <= selectedVal) {
                        $(this).removeClass('bi-star text-muted text-opacity-25').addClass(
                            'bi-star-fill text-warning');
                    } else {
                        $(this).removeClass('bi-star-fill text-warning').addClass(
                            'bi-star text-muted text-opacity-25');
                    }
                });
            });

            $(document).on('click', '.star-item', function() {
                const val = $(this).data('val');
                const container = $(this).closest('.star-rating-container');
                const hiddenInput = container.find('input[type="hidden"]');

                hiddenInput.val(val);

                container.removeClass('border border-danger bg-danger bg-opacity-10');
                container.siblings('.invalid-feedback').hide();

                if (hiddenInput.hasClass('error') || hiddenInput.hasClass('is-invalid')) {
                    hiddenInput.valid();
                }
            });

            // --- Single Image Preview Logic ---
            $(document).on('change', '.img-upload-input', function() {
                const index = $(this).data('index');
                const previewImg = $(`#preview-${index}`);
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Fallback if file upload is canceled and no DB image existed
                    previewImg.attr('src', defaultAvatar);
                }
            });

            // Open Modal for Bulk Add
            $('#addTestimonialsBtn').on('click', function() {
                $('#dynamicTestimonialsContainer').empty();
                rowIdx = 0;
                appendRow(rowIdx);
                $('#testimonialModalLabel').text('Add Testimonials');
                $('.is-invalid').removeClass('is-invalid');
                $('.star-rating-container').removeClass('border border-danger bg-danger bg-opacity-10');
                testimonialModal.show();
            });

            // Add More Row
            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                appendRow(rowIdx);
            });

            // Remove Row
            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicTestimonialsContainer .testimonial-row-item').length > 1) {
                    $(this).closest('.testimonial-row-item').remove();
                } else {
                    alert('At least one testimonial entry is required.');
                }
            });

            // Open Modal for Single Edit
            $(document).on('click', '.edit-testimonial-btn', function() {
                const btn = $(this);
                $('#dynamicTestimonialsContainer').empty();
                rowIdx = 0;

                const editData = {
                    id: btn.data('id'),
                    name: btn.data('name'),
                    rating: btn.data('rating'),
                    comment: btn.data('comment'),
                    image: btn.data('image')
                };

                appendRow(rowIdx, editData);
                $('#testimonialModalLabel').text('Edit Testimonial');
                $('.is-invalid').removeClass('is-invalid');
                $('.star-rating-container').removeClass('border border-danger bg-danger bg-opacity-10');
                testimonialModal.show();
            });

            // Delete AJAX
            $(document).on('click', '.delete-testimonial-btn', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this testimonial?')) return;

                $.ajax({
                    url: "{{ route('admin.testimonial') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        testimonial_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // Form Validation & Submit
            $('#testimonialForm').validate({
                ignore: ":hidden:not(.req-rating)",
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    if ($(element).hasClass('req-rating')) {
                        const container = $(element).closest('.star-rating-container');
                        container.addClass('border border-danger bg-danger bg-opacity-10');
                        container.siblings('.error-testimonials-' + container.data('index') + '-rating')
                            .show();
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    if ($(element).hasClass('req-rating')) {
                        const container = $(element).closest('.star-rating-container');
                        container.removeClass('border border-danger bg-danger bg-opacity-10');
                        container.siblings('.error-testimonials-' + container.data('index') + '-rating')
                            .hide();
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('req-rating')) {
                        error.insertAfter(element.closest('.star-rating-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.star-rating-container').removeClass(
                        'border border-danger bg-danger bg-opacity-10');

                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin.testimonial') }}",
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
                                window.location.reload();
                            }
                        },
                        error: function(xhr) {
                            $('#saveBtn').prop('disabled', false);
                            $('#saveBtnText').text('Save All Testimonials');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g,
                                        '-');
                                    const feedbackEl = $(`.error-${sanitizedKey}`);

                                    feedbackEl.text(messages[0]).show();

                                    if (fieldKey.includes('rating')) {
                                        const container = feedbackEl.closest(
                                            '.col-md-6').find(
                                            '.star-rating-container');
                                        container.addClass(
                                            'border border-danger bg-danger bg-opacity-10'
                                            );
                                    } else {
                                        feedbackEl.closest('.col-md-6, .col-md-12')
                                            .find('input, select, textarea')
                                            .addClass('is-invalid');
                                    }
                                });
                            } else {
                                $('#ajaxAlertMessage').text(
                                    'An unexpected error occurred. Please try again.');
                                $('#ajaxAlert').removeClass('d-none alert-success')
                                    .addClass('alert-danger');
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
