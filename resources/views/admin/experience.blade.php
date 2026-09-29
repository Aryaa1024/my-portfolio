@extends('admin.layouts.app')

@push('page-style')
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Experiences</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Experiences</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addExperienceBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Experience
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Experiences Cards Container -->
    <div class="row" id="experiencesList">
        @forelse($experiences as $exp)
            <div class="col-12 mb-4 experience-card-wrapper" id="experience-card-{{ $exp->id }}">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title fw-bold text-primary mb-1">{{ $exp->role }}</h5>
                                <h6 class="text-success mb-2">
                                    <i class="bi bi-building me-1"></i> {{ $exp->company }}
                                    <span
                                        class="badge bg-secondary ms-2">{{ ucwords(str_replace('_', ' ', $exp->employment_type)) }}</span>
                                </h6>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} -
                                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-exp-btn" data-id="{{ $exp->id }}"
                                    data-role="{{ $exp->role }}" data-company="{{ $exp->company }}"
                                    data-type="{{ $exp->employment_type }}" data-start="{{ $exp->start_date }}"
                                    data-end="{{ $exp->end_date }}" data-desc="{{ $exp->description }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-exp-btn" data-id="{{ $exp->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        @if ($exp->description)
                            <hr class="my-2">
                            <p class="mb-0 text-secondary" style="white-space: pre-line;">{{ $exp->description }}</p>
                        @endif
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
            <div class="col-12 card" id="noExperiencesMsg">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No experiences added yet. Click <strong>"Add Experience"</strong> to build your profile.
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

    <!-- Bulk Experiences Modal -->
    <div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="experienceModalLabel">Manage Experiences</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="experienceForm" novalidate>
                    @csrf
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <!-- Dynamic Form Rows Container -->
                        <div id="dynamicExperiencesContainer"></div>

                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-outline-success" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Experience
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save Experiences</span>
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
            const experienceModal = new bootstrap.Modal(document.getElementById('experienceModal'));
            let rowIdx = 0;

            const empTypes = {
                'full_time': 'Full-Time',
                'part_time': 'Part-Time',
                'contract': 'Contract',
                'freelance': 'Freelance',
                'internship': 'Internship'
            };

            // 1. CLASS-BASED JQUERY VALIDATION RULES
            $.validator.addClassRules("req-role", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-company", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("req-emp-type", {
                required: true
            });
            $.validator.addClassRules("req-start", {
                required: true,
                date: true
            });

            // 2. TEMPLATE GENERATOR FOR ROW
            function appendExperienceRow(index, data = {}) {
                let empOptions = '<option value="">Select Type...</option>';
                for (const [val, label] of Object.entries(empTypes)) {
                    const selected = (data.type === val) ? 'selected' : '';
                    empOptions += `<option value="${val}" ${selected}>${label}</option>`;
                }

                const rowHtml = `
                    <div class="card mb-4 experience-row-item shadow-sm" id="row-item-${index}">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-briefcase me-2"></i>Experience #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="experiences[${index}][id]" value="${data.id || ''}">
                            
                            <div class="row g-3">
                                <!-- Role -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Role / Job Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control req-role" name="experiences[${index}][role]" 
                                        value="${data.role || ''}" placeholder="e.g. Senior Software Engineer">
                                    <div class="invalid-feedback error-experiences-${index}-role"></div>
                                </div>

                                <!-- Company -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control req-company" name="experiences[${index}][company]" 
                                        value="${data.company || ''}" placeholder="e.g. Google, Apple, etc.">
                                    <div class="invalid-feedback error-experiences-${index}-company"></div>
                                </div>

                                <!-- Employment Type -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Employment Type <span class="text-danger">*</span></label>
                                    <select class="form-select req-emp-type" name="experiences[${index}][employment_type]">
                                        ${empOptions}
                                    </select>
                                    <div class="invalid-feedback error-experiences-${index}-employment_type"></div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control req-start" name="experiences[${index}][start_date]" 
                                        value="${data.start || ''}">
                                    <div class="invalid-feedback error-experiences-${index}-start_date"></div>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">End Date <span class="text-muted fw-normal">(Leave blank if current)</span></label>
                                    <input type="date" class="form-control" name="experiences[${index}][end_date]" 
                                        value="${data.end || ''}">
                                    <div class="invalid-feedback error-experiences-${index}-end_date"></div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Description / Responsibilities</label>
                                    <textarea class="form-control" name="experiences[${index}][description]" rows="3" 
                                        placeholder="Describe your achievements and responsibilities...">${data.desc || ''}</textarea>
                                    <div class="invalid-feedback error-experiences-${index}-description"></div>
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

                $('#dynamicExperiencesContainer').append(rowHtml);
            }

            // 3. DYNAMIC ROW HANDLERS
            $('#addExperienceBtn').on('click', function() {
                $('#dynamicExperiencesContainer').empty();
                rowIdx = 0;
                appendExperienceRow(rowIdx);
                $('#experienceModalLabel').text('Add Experience');
                $('.is-invalid').removeClass('is-invalid');
                experienceModal.show();
            });

            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                appendExperienceRow(rowIdx);
            });

            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicExperiencesContainer .experience-row-item').length > 1) {
                    $(this).closest('.experience-row-item').remove();
                } else {
                    alert('At least one experience entry is required in the form.');
                }
            });

            // Edit Action
            $(document).on('click', '.edit-exp-btn', function() {
                const btn = $(this);
                $('#dynamicExperiencesContainer').empty();
                rowIdx = 0;

                appendExperienceRow(rowIdx, {
                    id: btn.data('id'),
                    role: btn.data('role'),
                    company: btn.data('company'),
                    type: btn.data('type'),
                    start: btn.data('start'),
                    end: btn.data('end'),
                    desc: btn.data('desc')
                });

                $('#experienceModalLabel').text('Edit Experience');
                $('.is-invalid').removeClass('is-invalid');
                experienceModal.show();
            });

            // Delete Action
            $(document).on('click', '.delete-exp-btn', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this experience record?')) return;

                $.ajax({
                    url: "{{ route('admin.experience') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        experience_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload(); // Reload page upon successful delete
                        }
                    }
                });
            });

            // 4. JQUERY VALIDATION & SUBMIT
            $('#experienceForm').validate({
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
                        existingFeedback.text(error.text()).show();
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $('.is-invalid').removeClass('is-invalid');
                    const formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.experience') }}",
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
                            $('#saveBtnText').text('Save Experiences');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g,
                                        '-');
                                    const feedbackEl = $(
                                        `.error-experiences-${sanitizedKey}`);

                                    feedbackEl.text(messages[0]).show();
                                    feedbackEl.siblings('input, select, textarea')
                                        .addClass('is-invalid');
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
