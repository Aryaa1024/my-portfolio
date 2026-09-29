@extends('admin.layouts.app')

@push('page-style')
    <style>
        /* Reusing Select2 styling from your skill layout */
        .select2-container {
            z-index: 1060 !important;
        }

        .input-group>.select2-container {
            flex: 1 1 auto !important;
            width: 1% !important;
        }

        .input-group>.select2-container .select2-selection {
            border: var(--bs-border-width, 1px) solid var(--bs-border-color, #dee2e6) !important;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            background-color: var(--bs-body-bg, #fff) !important;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out !important;
        }

        .input-group-sm>.select2-container .select2-selection--single {
            height: calc(1.5em + 0.5rem + 2px) !important;
            min-height: calc(1.5em + 0.5rem + 2px) !important;
            padding: 0.25rem 2.25rem 0.25rem 0.5rem !important;
            font-size: 0.875rem !important;
            display: flex !important;
            align-items: center !important;
        }

        .input-group-sm>.select2-container .select2-selection__rendered {
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1.5 !important;
            color: var(--bs-body-color, #212529) !important;
            width: 100%;
        }

        .input-group-sm>.select2-container .select2-selection__arrow {
            height: 100% !important;
            top: 0 !important;
            right: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
        }

        .input-group-sm>.select2-container .select2-selection__clear {
            display: flex;
            align-items: center;
            height: 100%;
            margin-right: 1.25rem;
            color: var(--bs-secondary-color, #6c757d);
        }

        .input-group>.select2-container.select2-container--focus .select2-selection,
        .input-group>.select2-container.select2-container--open .select2-selection {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            z-index: 3 !important;
            outline: 0 !important;
        }

        .input-group>.select2-container .select2-selection.is-invalid {
            border-color: var(--bs-form-invalid-border-color, #dc3545) !important;
        }

        .input-group>.select2-container.select2-container--focus .select2-selection.is-invalid,
        .input-group>.select2-container.select2-container--open .select2-selection.is-invalid {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

        .select2-dropdown {
            border: var(--bs-border-width, 1px) solid var(--bs-border-color, #dee2e6) !important;
            border-radius: var(--bs-border-radius, 0.375rem) !important;
            background-color: var(--bs-body-bg, #ffffff) !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .select2-search--dropdown {
            padding: 0.5rem !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: var(--bs-border-width, 1px) solid var(--bs-border-color, #dee2e6) !important;
            border-radius: var(--bs-border-radius, 0.375rem) !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 0.875rem !important;
            background-color: var(--bs-body-bg, #ffffff) !important;
            color: var(--bs-body-color, #212529) !important;
            outline: none !important;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        .select2-results__options {
            color: var(--bs-body-color, #212529) !important;
            padding: 0.25rem 0 !important;
        }

        .select2-results__option {
            padding: 0.375rem 1rem !important;
            font-size: 0.875rem !important;
            background-color: transparent !important;
            color: var(--bs-body-color, #212529) !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected],
        .select2-results__option:hover {
            background-color: var(--bs-primary, #0d6efd) !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-results__option[aria-selected="true"],
        .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
            background-color: var(--bs-gray-200, #e9ecef) !important;
            color: var(--bs-body-color, #212529) !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected="true"],
        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected="true"] {
            background-color: var(--bs-primary, #0d6efd) !important;
            color: #ffffff !important;
        }

        .select2-results__message {
            color: var(--bs-secondary-color, #6c757d) !important;
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Services</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Services</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addServicesBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Services
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Services Cards Container -->
    <div class="row" id="servicesList">
        @forelse($services as $service)
            <div class="col-md-6 col-lg-4 mb-4 service-card-wrapper" id="service-card-{{ $service->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="border rounded p-2 d-flex align-items-center justify-content-center"
                                    style="width: 46px; height: 46px; min-width: 46px;">
                                    <i class="bi {{ $service->icon ?: 'bi-stars' }} fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold text-primary mb-0">{{ $service->title }}</h5>
                                </div>
                            </div>
                            <p class="card-text text-muted small">{{ $service->description ?? 'No description provided.' }}
                            </p>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                            <button class="btn btn-sm btn-outline-primary edit-service-btn" data-id="{{ $service->id }}"
                                data-title="{{ $service->title }}" data-icon="{{ $service->icon }}"
                                data-description="{{ $service->description }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-service-btn" data-id="{{ $service->id }}">
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
            <div class="col-12 card" id="noServicesMsg">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No services added yet. Click <strong>"Add Services"</strong> to get started.
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

    <!-- Bulk Services Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Manage Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="serviceForm" novalidate>
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Dynamic Form Rows Container -->
                        <div id="dynamicServicesContainer"></div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success btn-sm" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Service
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save All Services</span>
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
            const serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'));
            let rowIdx = 0;
            let availableIcons = [];

            // Fetch Icons for Select2
            $.getJSON('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.json')
                .done(function(data) {
                    availableIcons = Object.keys(data).map(function(iconName) {
                        return {
                            id: 'bi-' + iconName,
                            text: iconName
                        };
                    });
                })
                .fail(function() {
                    availableIcons = [{
                            id: 'bi-code-slash',
                            text: 'code-slash'
                        },
                        {
                            id: 'bi-terminal',
                            text: 'terminal'
                        },
                        {
                            id: 'bi-globe',
                            text: 'globe'
                        },
                        {
                            id: 'bi-palette',
                            text: 'palette'
                        },
                        {
                            id: 'bi-stars',
                            text: 'stars'
                        }
                    ];
                });

            function formatSelect2Icon(state) {
                if (!state.id) return state.text;
                return $(`<span><i class="bi ${state.id} me-2 text-light"></i>${state.text}</span>`);
            }

            $.validator.addClassRules("req-service-title", {
                required: true,
                maxlength: 255
            });

            function appendServiceRow(index, data = {}) {
                const currentIcon = data.icon || '';
                const title = data.title ? data.title.replace(/"/g, '&quot;') : '';
                const description = data.description ? data.description : '';

                const rowHtml = `
                    <div class="service-row-item card mb-3 position-relative" id="row-item-${index}">
                        <div class="d-flex card-header justify-content-between align-items-center p-2">
                            <h6 class="fw-bold mb-0">Service #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="services[${index}][id]" value="${data.id || ''}">
                            <div class="row g-3">
                                <!-- Title -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Service Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm req-service-title" 
                                        name="services[${index}][title]" 
                                        value="${title}" placeholder="e.g. Web Development">
                                    <div class="invalid-feedback error-services-${index}-title">Please enter service title.</div>
                                </div>

                                <!-- Icon Select -->
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Select Icon</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text icon-preview-box">
                                            <i class="bi ${currentIcon || 'bi-stars'} icon-preview-i"></i>
                                        </span>
                                        <select class="form-select form-select-sm service-icon-select" name="services[${index}][icon]" id="service-icon-${index}">
                                            <option value="">Search or Select Icon...</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback error-services-${index}-icon">Please select a valid icon.</div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Description</label>
                                    <textarea class="form-control form-control-sm" name="services[${index}][description]" rows="3" placeholder="Describe the service...">${description}</textarea>
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

                $('#dynamicServicesContainer').append(rowHtml);

                const selectEl = $(`#service-icon-${index}`);
                selectEl.select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#serviceModal'),
                    data: availableIcons,
                    placeholder: 'Search icon...',
                    width: 'style',
                    templateResult: formatSelect2Icon,
                    templateSelection: formatSelect2Icon
                });

                if (currentIcon) {
                    selectEl.val(currentIcon).trigger('change.select2');
                } else {
                    selectEl.val('').trigger('change.select2');
                }

                selectEl.on('change.select2', function() {
                    const val = $(this).val();
                    const previewIcon = $(this).closest('.col-md-6').find('.icon-preview-i');
                    if (val) {
                        previewIcon.attr('class', 'bi ' + val + ' icon-preview-i');
                    } else {
                        previewIcon.attr('class', 'bi bi-stars icon-preview-i');
                    }
                    if ($(this).valid) {
                        $(this).valid();
                    }
                });
            }

            // Open Modal for Bulk Add
            $('#addServicesBtn').on('click', function() {
                $('#dynamicServicesContainer').empty();
                rowIdx = 0;
                appendServiceRow(rowIdx);
                $('#serviceModalLabel').text('Add Services');
                $('.is-invalid').removeClass('is-invalid');
                serviceModal.show();
            });

            // Add More Row
            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                appendServiceRow(rowIdx);
            });

            // Remove Row
            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicServicesContainer .service-row-item').length > 1) {
                    $(this).closest('.service-row-item').remove();
                } else {
                    alert('At least one service entry is required.');
                }
            });

            // Open Modal for Single Edit
            $(document).on('click', '.edit-service-btn', function() {
                const btn = $(this);
                $('#dynamicServicesContainer').empty();
                rowIdx = 0;

                const editData = {
                    id: btn.data('id'),
                    title: btn.data('title'),
                    icon: btn.data('icon'),
                    description: btn.data('description')
                };

                appendServiceRow(rowIdx, editData);
                $('#serviceModalLabel').text('Edit Service');
                $('.is-invalid').removeClass('is-invalid');
                serviceModal.show();
            });

            // Delete Card AJAX
            $(document).on('click', '.delete-service-btn', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this service?')) return;

                $.ajax({
                    url: "{{ route('admin.service') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        service_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // Form Validation & Submit
            $('#serviceForm').validate({
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    $(element).closest('.col-md-6').find('.select2-container .select2-selection')
                        .addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.col-md-6').find('.select2-container .select2-selection')
                        .removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    const parentCol = element.closest('.col-md-6');
                    const existingFeedback = parentCol.find('.invalid-feedback');
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
                        url: "{{ route('admin.service') }}",
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
                            $('#saveBtnText').text('Save All Services');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g,
                                        '-');
                                    const feedbackEl = $(`.error-${sanitizedKey}`);

                                    feedbackEl.text(messages[0]).show();
                                    const parentCol = feedbackEl.closest(
                                        '.col-md-6');
                                    parentCol.find('input, select').addClass(
                                        'is-invalid');
                                    parentCol.find(
                                            '.select2-container .select2-selection')
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
