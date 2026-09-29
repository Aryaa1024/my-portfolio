@extends('admin.layouts.app')

@push('page-style')
    <style>
        /* Carousel image constraint to prevent layout breaking */
        .carousel-item img {
            height: 200px;
            object-fit: cover;
        }

        /* Make remove buttons strictly circular and small */
        .remove-img-btn {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Projects</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Projects</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addProjectBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Project
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Projects Cards Container -->
    <div class="row" id="projectsList">
        @forelse($projects as $project)
            @php
                // Safely decode images array
                $images = is_array($project->images) ? $project->images : json_decode($project->images, true) ?? [];
            @endphp

            <div class="col-md-6 col-lg-4 mb-4 project-card-wrapper">
                <div class="card p-2 shadow-sm h-100">

                    <!-- Carousel OR Single Image -->
                    @if (count($images) > 1)
                        <div id="carousel-{{ $project->id }}" class="carousel slide" data-bs-ride="carousel"
                            data-bs-interval="3000">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $img)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" alt="Project Image">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carousel-{{ $project->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"
                                    style="width:22px; height:22px; filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.8));"></span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carousel-{{ $project->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"
                                    style="width:22px; height:22px; filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.8));"></span>
                            </button>
                        </div>
                    @elseif(count($images) == 1)
                        <img src="{{ asset('storage/' . $images[0]) }}" class="card-img-top" alt="Project Image"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted"
                            style="height: 200px;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary mb-1">{{ $project->title }}</h5>
                        @if ($project->excerpt)
                            <p class="text-secondary small mb-2">{{ Str::limit($project->excerpt, 100) }}
                            </p>
                        @endif

                        <div class="mt-auto pt-3 d-flex justify-content-between align-items-center border-top">
                            <div>
                                @if ($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-globe me-1"></i> URL
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-project-btn"
                                    data-id="{{ $project->id }}" data-title="{{ $project->title }}"
                                    data-excerpt="{{ $project->excerpt }}" data-desc="{{ $project->description }}"
                                    data-url="{{ $project->live_url }}" data-images='@json($images)'>
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-project-btn"
                                    data-id="{{ $project->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
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
            </div>
        @empty
            <div class="col-12 card" id="noProjectsMsg">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No projects added yet. Click <strong>"Add Project"</strong> to showcase your work.
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

    <!-- Bulk Projects Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">Manage Projects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="projectForm" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div id="dynamicProjectsContainer"></div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-outline-success" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Project
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save Projects</span>
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
            const projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
            let rowIdx = 0;

            // Object to track new File selections per row index
            let newFileStore = {};

            // -------------------------------------------------------------
            // 1. JQUERY VALIDATION RULES
            // -------------------------------------------------------------
            $.validator.addClassRules("req-title", {
                required: true,
                maxlength: 255
            });
            $.validator.addClassRules("opt-url", {
                url: true,
                maxlength: 255
            });

            // File Ext validation
            $.validator.addMethod('acceptExtMultiple', function(value, element, param) {
                if (this.optional(element)) return true;
                const exts = param.split(',');
                for (let i = 0; i < element.files.length; i++) {
                    const ext = element.files[i].name.split('.').pop().toLowerCase();
                    if (!exts.includes(ext)) return false;
                }
                return true;
            }, "Only jpg, jpeg, png, webp files are allowed.");

            // File Size validation
            $.validator.addMethod('maxSizeMultiple', function(value, element, param) {
                if (this.optional(element)) return true;
                for (let i = 0; i < element.files.length; i++) {
                    if (element.files[i].size > param) return false;
                }
                return true;
            }, function(param, element) {
                return `Each file must be less than ${(param / 1024 / 1024).toFixed(0)} MB`;
            });

            // Total Count Validation (Existing + New)
            $.validator.addMethod('maxTotalImages', function(value, element, param) {
                const index = $(element).data('index');
                const existingCount = $(`#existing-previews-${index} .existing-img-box`).length;
                const newCount = element.files.length;
                return (existingCount + newCount) <= param;
            }, "Maximum {0} images allowed in total (existing + new).");

            $.validator.addClassRules("opt-images", {
                acceptExtMultiple: "jpg,jpeg,png,webp",
                maxSizeMultiple: 5242880, // 5 MB
                maxTotalImages: 5
            });

            // -------------------------------------------------------------
            // 2. LIVE PREVIEW LOGIC & FILE REMOVAL
            // -------------------------------------------------------------
            // Handle new file selection
            $(document).on('change', '.opt-images', function(e) {
                const index = $(this).data('index');
                const files = Array.from(e.target.files);

                // Store files in our local variable to allow array manipulation
                newFileStore[index] = files;
                renderNewPreviews(index, this);
            });

            // Handle remove of NEW uploads
            $(document).on('click', '.remove-new-btn', function() {
                const index = $(this).data('index');
                const fileIdx = $(this).data('fileidx');
                const inputElement = document.getElementById(`file-input-${index}`);

                // Remove file from array
                newFileStore[index].splice(fileIdx, 1);

                // Re-render
                renderNewPreviews(index, inputElement);
                $(inputElement).valid(); // Re-trigger validation
            });

            // Render NEW file previews and reconstruct input.files
            function renderNewPreviews(index, inputElement) {
                const container = $(`#new-previews-${index}`);
                container.empty();

                const dt = new DataTransfer();
                const files = newFileStore[index] || [];

                files.forEach((file, fileIdx) => {
                    dt.items.add(file); // Reconstruct native FileList

                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            container.append(`
                                <div class="position-relative d-inline-block me-2 mb-2">
                                    <img src="${e.target.result}" class="img-thumbnail shadow-sm" style="height:80px; width:80px; object-fit:cover; border-radius: 8px;">
                                    <span class="remove-img-btn bg-danger text-white rounded-circle position-absolute top-0 start-100 translate-middle remove-new-btn" data-index="${index}" data-fileidx="${fileIdx}"><i class="bi bi-x"></i></span>
                                </div>
                            `);
                        }
                        reader.readAsDataURL(file);
                    }
                });

                inputElement.files = dt.files; // Apply back to native input
            }

            // Handle remove of EXISTING images
            $(document).on('click', '.remove-existing-btn', function() {
                const index = $(this).data('index');
                $(this).closest('.existing-img-box')
                    .remove(); // Removes both preview and hidden input$(`#file-input-${index}`).valid(); // Re-validate total count
            });

            // -------------------------------------------------------------
            // 3. TEMPLATE GENERATOR FOR ROW
            // -------------------------------------------------------------
            function appendProjectRow(index, data = {}) {
                let existingPreviews = '';

                // Render existing images with hidden inputs to preserve them
                if (data.images && data.images.length > 0) {
                    data.images.forEach((path) => {
                        let absoluteUrl = '{{ asset('storage') }}/' + path;
                        existingPreviews += `
                            <div class="position-relative d-inline-block me-2 mb-2 existing-img-box">
                                <img src="${absoluteUrl}" class="img-thumbnail shadow-sm" style="height:80px; width:80px; object-fit:cover; border-radius: 8px;">
                                <input type="hidden" name="projects[${index}][existing_images][]" value="${path}">
                                <span class="remove-img-btn bg-danger text-white rounded-circle position-absolute top-0 start-100 translate-middle remove-existing-btn" data-index="${index}"><i class="bi bi-x"></i></span>
                            </div>
                        `;
                    });
                }

                const imgNote =
                    `<small class="text-muted d-block mt-1">Select up to 5 files (JPG, PNG, WEBP). Max 5MB each.</small>`;

                const rowHtml = `
                    <div class="card mb-4 project-row-item shadow-sm" id="row-item-${index}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-folder me-2"></i>Project #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="projects[${index}][id]" value="${data.id || ''}">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Project Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control req-title" name="projects[${index}][title]" 
                                        value="${data.title || ''}" placeholder="e.g. E-Commerce Dashboard">
                                    <div class="invalid-feedback error-projects-${index}-title"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Live URL <span class="text-muted fw-normal">(Optional)</span></label>
                                    <input type="url" class="form-control opt-url" name="projects[${index}][live_url]" 
                                        value="${data.url || ''}" placeholder="https://...">
                                    <div class="invalid-feedback error-projects-${index}-live_url"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Short Excerpt / Tagline <span class="text-muted fw-normal">(Optional)</span></label>
                                    <input type="text" class="form-control" name="projects[${index}][excerpt]" 
                                        value="${data.excerpt || ''}" placeholder="A brief one-sentence summary of the project.">
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Detailed Description</label>
                                    <textarea class="form-control" name="projects[${index}][description]" rows="4" 
                                        placeholder="Describe the tech stack, features, and your role...">${data.desc || ''}</textarea>
                                </div>

                                <div class="col-12">
                                    <div class="card">
                                    <div class="card-body">
                                    <label class="form-label small fw-semibold">Project Images</label>
                                    
                                    <!-- Container for Previously Saved Images -->
                                    <div id="existing-previews-${index}">
                                        ${existingPreviews}
                                    </div>
                                    
                                    <!-- Container for New Image Previews -->
                                    <div id="new-previews-${index}" class="mt-2"></div>
                                    
                                    <input type="file" class="form-control opt-images mt-2" id="file-input-${index}" data-index="${index}" name="projects[${index}][images][]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                                    ${imgNote}
                                    <div class="invalid-feedback error-projects-${index}-images"></div>
                                    </div>
                                    <div class="card-arrow">
                                        <div class="card-arrow-top-left"></div>
                                        <div class="card-arrow-top-right"></div>
                                        <div class="card-arrow-bottom-left"></div>
                                        <div class="card-arrow-bottom-right"></div>
                                    </div>
                                    </div>
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

                $('#dynamicProjectsContainer').append(rowHtml);
                newFileStore[index] = []; // Initialize empty file store for this row
            }

            // -------------------------------------------------------------
            // 4. DYNAMIC ROW HANDLERS
            // -------------------------------------------------------------
            $('#addProjectBtn').on('click', function() {
                $('#dynamicProjectsContainer').empty();
                newFileStore = {};
                rowIdx = 0;
                appendProjectRow(rowIdx);
                $('#projectModalLabel').text('Add Projects');
                $('.is-invalid').removeClass('is-invalid');
                projectModal.show();
            });

            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                appendProjectRow(rowIdx);
            });

            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicProjectsContainer .project-row-item').length > 1) {
                    const index = $(this).data('index');
                    delete newFileStore[index];
                    $(this).closest('.project-row-item').remove();
                } else {
                    alert('At least one project entry is required in the form.');
                }
            });

            // Edit Action
            $(document).on('click', '.edit-project-btn', function() {
                const btn = $(this);
                $('#dynamicProjectsContainer').empty();
                newFileStore = {};
                rowIdx = 0;

                appendProjectRow(rowIdx, {
                    id: btn.data('id'),
                    title: btn.data('title'),
                    excerpt: btn.data('excerpt'),
                    desc: btn.data('desc'),
                    url: btn.data('url'),
                    images: btn.data('images')
                });

                $('#projectModalLabel').text('Edit Project');
                $('.is-invalid').removeClass('is-invalid');
                projectModal.show();
            });

            // Delete Action
            $(document).on('click', '.delete-project-btn', function() {
                const id = $(this).data('id');
                if (!confirm(
                        'Are you sure you want to delete this project? All associated images will be permanently removed.'
                    )) return;

                $.ajax({
                    url: "{{ route('admin.project') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        project_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // -------------------------------------------------------------
            // 5. JQUERY VALIDATION & SUBMIT
            // -------------------------------------------------------------
            $('#projectForm').validate({
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

                    $.ajax({
                        url: "{{ route('admin.project') }}",
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
                            $('#saveBtnText').text('Save Projects');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g,
                                        '-');
                                    const feedbackEl = $(`.error-${sanitizedKey}`);

                                    if (feedbackEl.length) {
                                        feedbackEl.text(messages[0]).show();
                                        feedbackEl.siblings(
                                            'input, select, textarea').addClass(
                                            'is-invalid');
                                    } else {
                                        alert(messages[0]);
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
