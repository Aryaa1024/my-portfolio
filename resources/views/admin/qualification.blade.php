@extends('admin.layouts.app')

@push('page-style')
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Qualifications</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Qualifications</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addQualificationsBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Qualifications
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Qualifications Cards Container -->
    <div class="row" id="qualificationsList">
        @forelse($qualifications as $qualification)
            <div class="col-md-6 col-lg-4 mb-4 qualification-card-wrapper" id="qualification-card-{{ $qualification->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold text-primary mb-0">{{ $qualification->course_name }}</h5>
                                <span class="badge border">{{ $qualification->course_start }} -
                                    {{ $qualification->course_end }}</span>
                            </div>
                            <p class="card-text mb-1 fw-semibold text-secondary">{{ $qualification->college }}</p>
                            <p class="card-text text-muted small mb-2"><i
                                    class="bi bi-building me-1"></i>{{ $qualification->board_or_university }}</p>
                            <div class="mt-2">
                                <span class="badge border">{{ strtoupper($qualification->type) }}:
                                    {{ $qualification->type_value }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                            <button class="btn btn-sm btn-outline-primary edit-qualification-btn"
                                data-id="{{ $qualification->id }}" data-course="{{ $qualification->course_name }}"
                                data-board="{{ $qualification->board_or_university }}"
                                data-college="{{ $qualification->college }}"
                                data-start="{{ $qualification->course_start }}"
                                data-end="{{ $qualification->course_end }}" data-type="{{ $qualification->type }}"
                                data-value="{{ $qualification->type_value }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-qualification-btn"
                                data-id="{{ $qualification->id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 card" id="noQualificationsMsg">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No qualifications added yet. Click <strong>"Add Qualifications"</strong> to add your details.
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Bulk Qualifications Modal -->
    <div class="modal fade" id="qualificationModal" tabindex="-1" aria-labelledby="qualificationModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qualificationModalLabel">Manage Qualifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="qualificationForm" novalidate>
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Dynamic Form Rows Container -->
                        <div id="dynamicQualificationsContainer"></div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success btn-sm" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Qualification
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save All Qualifications</span>
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
            const qualificationModal = new bootstrap.Modal(document.getElementById('qualificationModal'));
            let rowIdx = 0;

            // -----------------------------------------------------------------
            // 1. CLASS-BASED JQUERY VALIDATION RULES FOR ARRAY INPUTS
            // -----------------------------------------------------------------
            $.validator.addClassRules("req-course-name", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-board", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-college", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-start", {
                required: true,
                maxlength: 50
            });
            $.validator.addClassRules("req-end", {
                required: true,
                maxlength: 50
            });
            $.validator.addClassRules("req-type", {
                required: true
            });
            $.validator.addClassRules("req-value", {
                required: true,
                maxlength: 50
            });

            // -----------------------------------------------------------------
            // 2. TEMPLATE GENERATOR FOR QUALIFICATION ROW
            // -----------------------------------------------------------------
            function generateRowHtml(index, data = {}) {
                return `
                    <div class="qualification-row-item card mb-3 position-relative" id="row-item-${index}">
                        <div class="d-flex card-header justify-content-between align-items-center p-2">
                            <h6 class="fw-bold mb-0">Qualification #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                        <input type="hidden" name="qualifications[${index}][id]" value="${data.id || ''}">
                        <div class="row g-3">
                            <!-- Course Name -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Course / Degree <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-course-name" 
                                    name="qualifications[${index}][course_name]" 
                                    value="${data.course_name || ''}" placeholder="e.g. B.Tech Computer Science">
                                <div class="invalid-feedback error-qualifications-${index}-course_name">Please enter course name.</div>
                            </div>

                            <!-- Board / University -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Board / University <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-board" 
                                    name="qualifications[${index}][board_or_university]" 
                                    value="${data.board_or_university || ''}" placeholder="e.g. AKTU / CBSE">
                                <div class="invalid-feedback error-qualifications-${index}-board_or_university">Please enter board or university.</div>
                            </div>

                            <!-- College -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">College / Institute <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-college" 
                                    name="qualifications[${index}][college]" 
                                    value="${data.college || ''}" placeholder="e.g. ABC Institute">
                                <div class="invalid-feedback error-qualifications-${index}-college">Please enter college or institute.</div>
                            </div>

                            <!-- Course Start -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Start Year <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-start" 
                                    name="qualifications[${index}][course_start]" 
                                    value="${data.course_start || ''}" placeholder="e.g. 2020">
                                <div class="invalid-feedback error-qualifications-${index}-course_start">Please enter start year.</div>
                            </div>

                            <!-- Course End -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">End Year <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-end" 
                                    name="qualifications[${index}][course_end]" 
                                    value="${data.course_end || ''}" placeholder="e.g. 2024">
                                <div class="invalid-feedback error-qualifications-${index}-course_end">Please enter end year.</div>
                            </div>

                            <!-- Score Type -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Score Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm req-type" name="qualifications[${index}][type]">
                                    <option value="">Select</option>
                                    <option value="percentage" ${data.type === 'percentage' ? 'selected' : ''}>Percentage (%)</option>
                                    <option value="cgpa" ${data.type === 'cgpa' ? 'selected' : ''}>CGPA</option>
                                    <option value="grade" ${data.type === 'grade' ? 'selected' : ''}>Grade</option>
                                </select>
                                <div class="invalid-feedback error-qualifications-${index}-type">Please select score type.</div>
                            </div>

                            <!-- Score Value -->
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Score / Value <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm req-value" 
                                    name="qualifications[${index}][type_value]" 
                                    value="${data.type_value || ''}" placeholder="e.g. 85%">
                                <div class="invalid-feedback error-qualifications-${index}-type_value">Please enter score value.</div>
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
                `;
            }

            // -----------------------------------------------------------------
            // 3. DYNAMIC ROW HANDLERS
            // -----------------------------------------------------------------

            // Open Modal for Bulk Add
            $('#addQualificationsBtn').on('click', function() {
                $('#dynamicQualificationsContainer').empty();
                rowIdx = 0;
                $('#dynamicQualificationsContainer').append(generateRowHtml(rowIdx));
                $('#qualificationModalLabel').text('Add Qualifications');
                $('.is-invalid').removeClass('is-invalid');
                qualificationModal.show();
            });

            // Add More Row
            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                $('#dynamicQualificationsContainer').append(generateRowHtml(rowIdx));
            });

            // Remove Row
            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicQualificationsContainer .qualification-row-item').length > 1) {
                    $(this).closest('.qualification-row-item').remove();
                } else {
                    alert('At least one qualification entry is required.');
                }
            });

            // Open Modal for Single Edit
            $(document).on('click', '.edit-qualification-btn', function() {
                const btn = $(this);
                $('#dynamicQualificationsContainer').empty();
                rowIdx = 0;

                const editData = {
                    id: btn.data('id'),
                    course_name: btn.data('course'),
                    board_or_university: btn.data('board'),
                    college: btn.data('college'),
                    course_start: btn.data('start'),
                    course_end: btn.data('end'),
                    type: btn.data('type'),
                    type_value: btn.data('value')
                };

                $('#dynamicQualificationsContainer').append(generateRowHtml(rowIdx, editData));
                $('#qualificationModalLabel').text('Edit Qualification');
                $('.is-invalid').removeClass('is-invalid');
                qualificationModal.show();
            });

            // Delete Card AJAX
            $(document).on('click', '.delete-qualification-btn', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this qualification?')) return;

                $.ajax({
                    url: "{{ route('admin.qualification') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        qualification_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload(); // Reload page upon successful delete
                        }
                    }
                });
            });

            // -----------------------------------------------------------------
            // 4. JQUERY VALIDATION & SUBMISSION
            // -----------------------------------------------------------------
            $('#qualificationForm').validate({
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    const existingFeedback = element.siblings('.invalid-feedback');
                    if (existingFeedback.length) {
                        existingFeedback.text(error.text());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $('.is-invalid').removeClass('is-invalid');

                    const formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.qualification') }}",
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
                                window.location
                            .reload(); // Reload page upon successful creation/edit
                            }
                        },
                        error: function(xhr) {
                            $('#saveBtn').prop('disabled', false);
                            $('#saveBtnText').text('Save All Qualifications');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g,
                                        '-');
                                    const feedbackEl = $(`.error-${sanitizedKey}`);

                                    feedbackEl.text(messages[0]);
                                    feedbackEl.prev('input, select').addClass(
                                        'is-invalid');
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
