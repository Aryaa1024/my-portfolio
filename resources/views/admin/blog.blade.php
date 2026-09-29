@extends('admin.layouts.app')

@push('page-style')
    <!-- Summernote Rich Text Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Tagify CSS for Keywords -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    <style>
        .remove-img-btn {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            z-index: 10;
        }

        /* Make Tagify look like Bootstrap 5 form-control */
        .tagify {
            --tags-border-color: #dee2e6;
            --tags-hover-border-color: #dee2e6;
            --tags-focus-border-color: #86b7fe;
            border-radius: 0.375rem;
            padding: 0.15rem 0.5rem;
            width: 100%;
        }

        /* Fix backdrop and modal layering */
        .note-modal-backdrop {
            z-index: 1050 !important;
        }

        .note-modal {
            z-index: 1060 !important;
        }

        /* Center the Summernote modal vertically and horizontally */
        .note-modal .modal-dialog {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
            margin: auto;
        }

        .note-modal-content {
            border: 1px solid grey !important;
        }

        /* Restore borders, shadow, and background */
        .note-modal .modal-content {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 100%;
        }

        /* Fix header layout and close button */
        .note-modal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .note-modal .modal-title {
            margin-bottom: 0;
            font-weight: 600;
        }

        .note-modal .close {
            background: transparent;
            border: 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: #000;
            opacity: 0.5;
            cursor: pointer;
        }

        .note-modal .close:hover {
            opacity: 0.75;
        }

        /* Fix body and footer padding */
        .note-modal .modal-body {
            padding: 1rem;
        }

        .note-modal .modal-footer {
            padding: 0.75rem;
            border-top: 1px solid #dee2e6;
        }

        .note-editor {
            border:1px solid grey;
        }

        .note-frame {}
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Blogs</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Blogs</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addBlogBtn">
                <i class="bi bi-plus-lg me-1"></i> Write New Blog
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Blogs Grid -->
    <div class="row" id="blogsList">
        @forelse($blogs as $blog)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 p-2">
                    @if ($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" class="" alt="Blog Image"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                            <i class="bi bi-journal-text fs-1"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold text-primary mb-0">{{ $blog->title }}</h5>
                            @if ($blog->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($blog->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @else
                                <span class="badge bg-warning text-dark">Archived</span>
                            @endif
                        </div>

                        <p class="text-secondary small mb-3 flex-grow-1">
                            {{ $blog->excerpt ? \Illuminate\Support\Str::limit($blog->excerpt, 100) : 'No excerpt provided.' }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                            <span class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $blog->created_at->format('M d, Y') }}
                            </span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-blog-btn" data-id="{{ $blog->id }}"
                                    data-title="{{ $blog->title }}" data-excerpt="{{ $blog->excerpt }}"
                                    data-keywords="{{ $blog->keywords }}" data-status="{{ $blog->status }}"
                                    data-image="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : '' }}"
                                    data-desc="{{ $blog->description }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-blog-btn"
                                    data-id="{{ $blog->id }}">
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
            <div class="col-12 card">
                <div class="card-body d-flex align-items-center justify-content-center">
                    No blogs found. Click <strong>"Write New Blog"</strong> to get started.
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

    <!-- Hidden file inputs to trigger OS File Dialog for Summernote directly -->
    <input type="file" id="summernote_image_input" accept="image/*" class="d-none">
    <input type="file" id="summernote_video_input" accept="video/*" class="d-none">

    <!-- Single Blog Modal -->
    <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalLabel">Manage Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="blogForm" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <input type="hidden" name="id" id="blog_id">
                                <input type="hidden" name="remove_image" id="remove_image" value="0">

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small fw-semibold">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter blog title">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Short Excerpt (SEO Description)</label>
                                        <input type="text" class="form-control" name="excerpt" id="excerpt"
                                            placeholder="A brief summary of the blog.">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Keywords(Comma Separated)</label>
                                        <input class="form-control" name="keywords" id="keywords"
                                            placeholder="Type a keyword and press Enter">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Featured Image (Max 2MB)</label>
                                        <input type="file" class="form-control" name="featured_image"
                                            id="featured_image" accept="image/jpeg,image/png,image/jpg,image/webp">

                                        <!-- Image Preview Box -->
                                        <div id="imagePreviewContainer"
                                            class="mt-2 d-none position-relative d-inline-block">
                                            <img id="imagePreview" src="" class="img-thumbnail shadow-sm"
                                                style="height:100px; width:150px; object-fit:cover; border-radius: 8px;">
                                            <span id="removeImageBtn"
                                                class="remove-img-btn bg-danger text-white rounded-circle position-absolute top-0 start-100 translate-middle">
                                                <i class="bi bi-x"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Rich Text Editor -->
                                    <div class="col-12 mt-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <label class="form-label small fw-semibold">Blog Content <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                                <!-- Hidden div to display validation errors for summernote -->
                                                <div id="description-error-box" class="invalid-feedback d-block"></div>
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save Blog</span>
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
    <!-- jQuery Validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- Tagify JS for Keywords -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script>
        $(document).ready(function() {
            const blogModal = new bootstrap.Modal(document.getElementById('blogModal'));

            // -------------------------------------------------------------
            // TAGIFY INITIALIZATION FOR KEYWORDS
            // -------------------------------------------------------------
            var keywordsInput = document.querySelector('#keywords');
            var tagify = new Tagify(keywordsInput, {
                // Submit tags as comma separated string rather than JSON
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });

            // -------------------------------------------------------------
            // CUSTOM SUMMERNOTE BUTTONS FOR DIRECT FILE SELECTION
            // -------------------------------------------------------------
            var CustomPictureButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-picture"></i>',
                    tooltip: 'Picture',
                    click: function() {
                        $('#summernote_image_input').trigger('click');
                    }
                });
                return button.render();
            };

            var CustomVideoButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-video"></i>',
                    tooltip: 'Video',
                    click: function() {
                        $('#summernote_video_input').trigger('click');
                    }
                });
                return button.render();
            };

            // Initialize Summernote
            $('#description').summernote({
                placeholder: 'Write your rich-text blog content here...',
                tabsize: 2,
                height: 350,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    // Use the standard identifiers here, but they will be mapped to our custom logic below
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help']]
                ],
                buttons: {
                    picture: CustomPictureButton,
                    video: CustomVideoButton
                }
            });

            // Handle direct Image selection for Summernote
            $('#summernote_image_input').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#description').summernote('insertImage', e.target.result, file.name);
                    };
                    reader.readAsDataURL(file);
                }
                $(this).val(''); // Reset input
            });

            // Handle direct Video selection for Summernote
            $('#summernote_video_input').on('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.size > 20971520) { // 20 MB limit safety
                        alert("Video is too large for direct editor insertion. Maximum 20MB allowed.");
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const videoNode = document.createElement('video');
                        videoNode.src = e.target.result;
                        videoNode.controls = true;
                        videoNode.style.maxWidth = '100%';

                        $('#description').summernote('insertNode', videoNode);

                        // Add a blank paragraph after the video for easier typing
                        const pNode = document.createElement('p');
                        pNode.innerHTML = '<br>';
                        $('#description').summernote('insertNode', pNode);
                    };
                    reader.readAsDataURL(file);
                }
                $(this).val(''); // Reset input
            });

            // -------------------------------------------------------------
            // REGULAR FEATURED IMAGE PREVIEW LOGIC
            // -------------------------------------------------------------
            $('#featured_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2097152) { // 2MB limit (2 * 1024 * 1024)
                        alert('Image size must be less than 2MB.');
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreviewContainer').removeClass('d-none');
                        $('#remove_image').val('0'); // Reset remove flag
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#removeImageBtn').on('click', function() {
                $('#featured_image').val(''); // Clear file input
                $('#imagePreview').attr('src', '');
                $('#imagePreviewContainer').addClass('d-none');
                $('#remove_image').val('1'); // Flag to backend to delete old image
            });

            // -------------------------------------------------------------
            // MODAL OPENERS
            // -------------------------------------------------------------
            $('#addBlogBtn').on('click', function() {
                $('#blogForm')[0].reset();
                $('#blog_id').val('');
                $('#remove_image').val('0');
                $('#description').summernote('code', ''); // Clear editor
                $('#imagePreviewContainer').addClass('d-none');

                tagify.removeAllTags(); // Clear tags

                $('#blogModalLabel').text('Write New Blog');
                $('.is-invalid').removeClass('is-invalid');
                $('#description-error-box').text('');
                blogModal.show();
            });

            $(document).on('click', '.edit-blog-btn', function() {
                const btn = $(this);
                $('#blogForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('#description-error-box').text('');

                $('#blog_id').val(btn.data('id'));
                $('#title').val(btn.data('title'));
                $('#status').val(btn.data('status'));
                $('#excerpt').val(btn.data('excerpt'));
                $('#description').summernote('code', btn.data('desc'));
                $('#remove_image').val('0');

                // Populate Tagify
                tagify.removeAllTags();
                if (btn.data('keywords')) {
                    tagify.addTags(btn.data('keywords'));
                }

                const image = btn.data('image');
                if (image) {
                    $('#imagePreview').attr('src', image);
                    $('#imagePreviewContainer').removeClass('d-none');
                } else {
                    $('#imagePreviewContainer').addClass('d-none');
                }

                $('#blogModalLabel').text('Edit Blog');
                blogModal.show();
            });

            // -------------------------------------------------------------
            // DELETE ACTION
            // -------------------------------------------------------------
            $(document).on('click', '.delete-blog-btn', function() {
                const id = $(this).data('id');
                if (!confirm('Are you sure you want to delete this blog?')) return;

                $.ajax({
                    url: "{{ route('admin.blog') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        blog_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // -------------------------------------------------------------
            // VALIDATION & FORM SUBMIT
            // -------------------------------------------------------------

            $.validator.addMethod('acceptExt', function(value, element, param) {
                if (this.optional(element)) return true;
                const ext = element.files[0].name.split('.').pop().toLowerCase();
                return param.split(',').includes(ext);
            }, "Only jpg, jpeg, png, webp files are allowed.");

            $.validator.addMethod('maxSize', function(value, element, param) {
                if (this.optional(element)) return true;
                return element.files[0].size <= param;
            }, function(param, element) {
                return `File size must be less than ${(param / 1024 / 1024).toFixed(0)} MB`;
            });

            $('#blogForm').validate({
                ignore: ".note-editor *", // Don't validate summernote's internal hidden fields automatically
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    status: {
                        required: true
                    },
                    featured_image: {
                        acceptExt: "jpg,jpeg,png,webp",
                        maxSize: 2097152 // 2 MB
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
                    // Fix validation placement for tagify
                    if ($(element).attr('id') === 'keywords') {
                        error.insertAfter($(element).next('.tagify'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('#description-error-box').text('');

                    const formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.blog') }}",
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
                            $('#saveBtnText').text('Save Blog');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(field, messages) {
                                    if (field === 'description') {
                                        $('#description-error-box').text(messages[
                                            0]);
                                    } else {
                                        const input = $(`#${field}`);
                                        // Specific handling for Tagify wrapper validation UI
                                        if (field === 'keywords') {
                                            input.next('.tagify').addClass(
                                                'is-invalid');
                                        } else {
                                            input.addClass('is-invalid');
                                        }

                                        if (input.next('.invalid-feedback')
                                            .length === 0) {
                                            input.after(
                                                `<div class="invalid-feedback">${messages[0]}</div>`
                                            );
                                        } else {
                                            input.next('.invalid-feedback').text(
                                                messages[0]);
                                        }
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
