@extends('admin.layouts.app')

@push('page-style')
@endpush

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">My Contacts</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <div class="row mb-4 d-flex align-items-center justify-content-between">
        <div class="col-sm-12 col-md-6">
            <h3 class="h3 mb-0">My Contacts</h3>
        </div>
        <div class="col-sm-12 col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary" id="addContactsBtn">
                <i class="bi bi-plus-lg me-1"></i> Add Contacts
            </button>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="ajaxAlert" class="alert alert-dismissible fade show d-none" role="alert">
        <span id="ajaxAlertMessage"></span>
        <button type="button" class="btn-close" onclick="$('#ajaxAlert').addClass('d-none');"></button>
    </div>

    <!-- Cards Container -->
    <div class="row" id="contactsList">
        @forelse($contacts as $contact)
            <div class="col-md-6 mb-4 contact-card-wrapper" id="contact-card-{{ $contact->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="border rounded p-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 46px; height: 46px;">
                                    <i class="bi bi-person-lines-fill fs-4 text-primary"></i>
                                </div>
                                <div style="min-width: 0;">
                                    <h5 class="card-title fw-bold text-primary mb-0 text-truncate" title="{{ $contact->name }}">{{ $contact->name }}</h5>
                                    <small class="text-muted d-block text-truncate" title="{{ $contact->email }}">{{ $contact->email }}</small>
                                </div>
                            </div>
                            @if($contact->mobile)
                                <div class="small mt-2 text-truncate" title="{{ $contact->mobile }}"><i class="bi bi-telephone me-1 text-muted"></i>{{ $contact->mobile }}</div>
                            @endif
                            <p class="card-text text-muted small mt-2 mb-0 border-top pt-2" title="{{ $contact->message }}">
                                "{{ Str::limit($contact->message, 80, '...') }}"
                            </p>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                            <button class="btn btn-sm btn-outline-primary edit-contact-btn" 
                                data-id="{{ $contact->id }}"
                                data-name="{{ $contact->name }}" 
                                data-email="{{ $contact->email }}"
                                data-mobile="{{ $contact->mobile }}"
                                data-message="{{ $contact->message }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-contact-btn" data-id="{{ $contact->id }}">
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
            <div class="col-12 card" id="noContactsMsg">
                <div class="card-body d-flex align-items-center justify-content-center py-4">
                    No contacts added yet. Click <strong>"Add Contacts"</strong> to add your contacts.
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

    <!-- Bulk Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Manage Contacts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contactForm" novalidate>
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div id="dynamicContactsContainer"></div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success btn-sm" id="addMoreRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Contact
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <span id="saveBtnText">Save All Contacts</span>
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
            const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
            let rowIdx = 0;

            // Validation Rules mapped to exact form fields
            $.validator.addClassRules("req-name", { required: true, maxlength: 255 });
            $.validator.addClassRules("req-email", { required: true, email: true, maxlength: 255 });
            $.validator.addClassRules("req-message", { required: true });

            function appendRow(index, data = {}) {
                // BUG FIX: Explicitly convert to String to avoid .replace() crashing on parsed Numbers
                const name = data.name ? String(data.name).replace(/"/g, '&quot;') : '';
                const email = data.email ? String(data.email).replace(/"/g, '&quot;') : '';
                const mobile = data.mobile ? String(data.mobile).replace(/"/g, '&quot;') : '';
                const message = data.message ? String(data.message).replace(/</g, '&lt;').replace(/>/g, '&gt;') : '';

                const rowHtml = `
                    <div class="contact-row-item card mb-3 position-relative" id="row-item-${index}">
                        <div class="d-flex card-header justify-content-between align-items-center p-2">
                            <h6 class="fw-bold mb-0">Contact #${index + 1}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" data-index="${index}">
                                <i class="bi bi-x-lg"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="contacts[${index}][id]" value="${data.id || ''}">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm req-name" 
                                        name="contacts[${index}][name]" value="${name}" placeholder="e.g. John Doe">
                                    <div class="invalid-feedback error-contacts-${index}-name">Please enter name.</div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-sm req-email" 
                                        name="contacts[${index}][email]" value="${email}" placeholder="john@example.com">
                                    <div class="invalid-feedback error-contacts-${index}-email">Please enter a valid email.</div>
                                </div>

                                <!-- Mobile -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Mobile Number</label>
                                    <input type="text" class="form-control form-control-sm" 
                                        name="contacts[${index}][mobile]" value="${mobile}" placeholder="+1 234 567 890">
                                </div>

                                <!-- Message -->
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm req-message" 
                                        name="contacts[${index}][message]" rows="3" placeholder="Enter message here...">${message}</textarea>
                                    <div class="invalid-feedback error-contacts-${index}-message">Please provide a message.</div>
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
                $('#dynamicContactsContainer').append(rowHtml);
            }

            // Open Modal for Bulk Add
            $('#addContactsBtn').on('click', function() {
                $('#dynamicContactsContainer').empty();
                rowIdx = 0;
                appendRow(rowIdx);
                $('#contactModalLabel').text('Add Contacts');
                $('.is-invalid').removeClass('is-invalid');
                contactModal.show();
            });

            // Add More Row
            $('#addMoreRowBtn').on('click', function() {
                rowIdx++;
                appendRow(rowIdx);
            });

            // Remove Row
            $(document).on('click', '.remove-row-btn', function() {
                if ($('#dynamicContactsContainer .contact-row-item').length > 1) {
                    $(this).closest('.contact-row-item').remove();
                } else {
                    alert('At least one contact entry is required.');
                }
            });

            // Open Modal for Single Edit
            $(document).on('click', '.edit-contact-btn', function() {
                const btn = $(this);$('#dynamicContactsContainer').empty();
                rowIdx = 0;

                // BUG FIX: using .attr() instead of .data() ensures we get strings, avoiding jQuery type parsing issues
                const editData = {
                    id: btn.attr('data-id'),
                    name: btn.attr('data-name'),
                    email: btn.attr('data-email'),
                    mobile: btn.attr('data-mobile'),
                    message: btn.attr('data-message')
                };

                appendRow(rowIdx, editData);
                $('#contactModalLabel').text('Edit Contact');
                $('.is-invalid').removeClass('is-invalid');
                contactModal.show();
            });

            // Delete AJAX
            $(document).on('click', '.delete-contact-btn', function() {
                const id = $(this).attr('data-id');
                if (!confirm('Are you sure you want to delete this contact?')) return;

                $.ajax({
                    url: "{{ route('admin.contact') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'delete',
                        contact_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    }
                });
            });

            // Form Validation & Submit
            $('#contactForm').validate({
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
                        url: "{{ route('admin.contact') }}",
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
                            $('#saveBtnText').text('Save All Contacts');
                            $('#saveBtnSpinner').addClass('d-none');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(fieldKey, messages) {
                                    const sanitizedKey = fieldKey.replace(/\./g, '-');
                                    const feedbackEl = $(`.error-${sanitizedKey}`);
                                    
                                    feedbackEl.text(messages[0]).show();
                                    feedbackEl.closest('.col-md-4, .col-md-12').find('input, textarea').addClass('is-invalid');
                                });
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