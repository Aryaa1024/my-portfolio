@extends('website.layouts.master')

@push('page-style')
    <style>
        .login-card {
            border: 0;
            border-radius: 1rem;
        }

        .login-card .card-header {
            padding-bottom: 0;
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 0 .2rem rgba(var(--bs-success-rgb), .15);
        }

        .login-card .otp-input {
            aspect-ratio: 1;
            width: 3rem;
            max-width: 3rem;
            padding: 0;
        }

        .login-card .otp-input.is-invalid {
            background-image: none;
            border-color: var(--bs-danger);
            padding-right: 0;
        }

        .login-card button[disabled] {
            cursor: wait;
        }
    </style>
@endpush

@section('page-content')
    <section class="container-fluid">

        <div class="row min-vh-100 d-flex align-items-center justify-content-center">

            <div class="col-12 col-sm-10 col-md-6 col-lg-5 col-xl-4">

                <div class="card login-card shadow-sm">
                    <div id="loginSection">

                        <div class="card-header border-0 text-center bg-transparent pt-4">

                            <h4 class="h4 mb-1">
                                Sign In
                            </h4>

                            <p class="text-muted mb-0">
                                For your protection, please verify your identity
                            </p>

                        </div>

                        <form id="loginForm" autocomplete="off">

                            @csrf

                            <input type="hidden" name="action" value="request_otp">

                            <div class="card-body p-4">

                                <div id="loginAlert" aria-live="polite"></div>

                                <div class="mb-4">

                                    <label class="form-label">
                                        Login With
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="form-check">

                                            <input class="form-check-input" type="radio" name="type" value="email"
                                                id="typeEmail" checked>

                                            <label class="form-check-label" for="typeEmail">
                                                Email
                                            </label>

                                        </div>

                                        <div class="form-check">

                                            <input class="form-check-input" type="radio" name="type" value="mobile"
                                                id="typeMobile">

                                            <label class="form-check-label" for="typeMobile">
                                                Mobile
                                            </label>

                                        </div>

                                    </div>

                                </div>

                                <div class="mb-4">

                                    <label for="identifier" class="form-label" id="identifierLabel">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="email" class="form-control form-control-lg" name="identifier"
                                        id="identifier" placeholder="Enter your email" autocomplete="email">

                                </div>

                                <div class="d-grid">

                                    <button type="submit" class="btn btn-outline-success" id="submitBtn"
                                        aria-live="polite">
                                        Request OTP
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div id="otpSection" class="d-none">

                        <div class="card-header border-0 text-center bg-transparent pt-4">

                            <h4 class="h4 mb-1">
                                Verify OTP
                            </h4>

                            <p class="text-muted mb-0">
                                Enter the 6 digit OTP sent to
                                <strong id="otpIdentifier"></strong>
                            </p>

                        </div>


                        <form id="otpForm" autocomplete="off">

                            @csrf

                            <input type="hidden" name="action" value="verify_otp">

                            <input type="hidden" name="type" id="otpType">

                            <input type="hidden" name="identifier" id="otpIdentifierValue">

                            <input type="hidden" name="otp" id="otp">


                            <div class="card-body p-4">

                                {{-- OTP Alert --}}
                                <div id="otpAlert" aria-live="polite"></div>

                                <div class="mb-4">

                                    <label class="form-label text-center d-block">
                                        One-Time Password
                                    </label>

                                    <div class="d-flex justify-content-center gap-2" id="otpInputs">

                                        @for ($i = 1; $i <= 6; $i++)
                                            <input type="text"
                                                class="form-control form-control-lg text-center fw-bold otp-input"
                                                maxlength="1" inputmode="numeric" autocomplete="one-time-code"
                                                id="otp_{{ $i }}" aria-label="OTP digit {{ $i }}">
                                        @endfor

                                    </div>

                                    <div id="otpError" class="invalid-feedback text-center"></div>

                                </div>

                                <div class="d-grid mb-3">

                                    <button type="submit" class="btn btn-outline-success" id="verifyOtpBtn"
                                        aria-live="polite">
                                        Verify OTP
                                    </button>

                                </div>

                                <div class="text-center">

                                    <span id="resendTimer" class="text-muted">
                                        Resend OTP in
                                        <strong id="countdown">60</strong>s
                                    </span>

                                    <button type="button" id="resendOtpBtn" class="btn btn-link p-0 d-none"
                                        aria-live="polite">
                                        Resend OTP
                                    </button>

                                </div>

                                <div class="text-center mt-3">

                                    <button type="button" id="changeLoginBtn" class="btn btn-link text-muted">
                                        Change email/mobile
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

            </div>

        </div>

    </section>
@endsection


@push('page-script')
    <script>
        $(document).ready(function() {

            let resendInterval = null;

            const resendSeconds = 60;

            let isRequestingOtp = false;
            let isVerifyingOtp = false;
            let isResendingOtp = false;


            const loginUrl = "{{ route('login') }}";

            $('input[name="type"]').on('change', function() {

                const isEmail = this.value === 'email';

                $('#identifierLabel').html(
                    `${isEmail ? 'Email' : 'Mobile'}
                <span class="text-danger">*</span>`
                );

                $('#identifier')
                    .attr(
                        'type',
                        isEmail ? 'email' : 'tel'
                    )
                    .attr(
                        'placeholder',
                        isEmail ?
                        'Enter your email' :
                        'Enter your mobile number'
                    )
                    .attr(
                        'autocomplete',
                        isEmail ?
                        'email' :
                        'tel'
                    )
                    .val('')
                    .removeClass('is-invalid');

                $('#identifier-error').remove();

                clearAlert('#loginAlert');

            });


            $('#loginForm').validate({
                rules: {
                    type: {
                        required: true
                    },
                    identifier: {
                        required: true,
                        email: {
                            depends: function() {
                                return $('input[name="type"]:checked').val() === 'email';
                            }
                        },
                        digits: {
                            depends: function() {
                                return $('input[name="type"]:checked').val() === 'mobile';
                            }
                        },
                        minlength: {
                            param: 10,
                            depends: function() {
                                return $('input[name="type"]:checked').val() === 'mobile';
                            }
                        },
                        maxlength: {
                            param: 10,
                            depends: function() {
                                return $('input[name="type"]:checked').val() === 'mobile';
                            }
                        }
                    }
                },
                messages: {
                    type: {
                        required: 'Please select a login type.'
                    },
                    identifier: {
                        required: 'Please enter your email or mobile number.',
                        email: 'Please enter a valid email address.',
                        digits: 'Mobile number must contain only digits.',
                        minlength: 'Mobile number must be 10 digits.',
                        maxlength: 'Mobile number must be 10 digits.'
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    if (element.attr('name') === 'type') {
                        error.insertAfter(
                            element.closest('.d-flex')
                        );
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element)
                        .addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element)
                        .removeClass('is-invalid');
                },
                submitHandler: function(form, event) {
                    if (event) {
                        event.preventDefault();
                    }
                    if (isRequestingOtp) {
                        return false;
                    }
                    requestOtp(form);
                    return false;
                }
            });

            function requestOtp(form) {
                const button = $('#submitBtn');
                if (isRequestingOtp || button.data('otpRequestPending')) {
                    return;
                }
                isRequestingOtp = true;
                button.data('otpRequestPending', true);
                clearAlert('#loginAlert');
                button
                    .prop('disabled', true)
                    .html(`
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Sending...
                `);
                $.ajax({
                    url: loginUrl,
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status !== 'success') {
                            showAlert(
                                '#loginAlert',
                                response.message ||
                                'Unable to send OTP.',
                                'danger'
                            );
                            return;
                        }
                        const type =
                            $('input[name="type"]:checked').val();
                        const identifier =
                            $('#identifier')
                            .val()
                            .trim();
                        $('#otpType')
                            .val(type);
                        $('#otpIdentifierValue')
                            .val(identifier);
                        $('#otpIdentifier')
                            .text(identifier);
                        resetOtp();
                        $('#loginSection')
                            .addClass('d-none');
                        $('#otpSection')
                            .removeClass('d-none');
                        startResendCountdown();
                        showAlert(
                            '#otpAlert',
                            response.message ||
                            'OTP sent successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            $('#otp_1').focus();
                        }, 100);
                    },
                    error: function(xhr) {
                        handleAjaxError(
                            xhr,
                            '#loginAlert'
                        );

                    },
                    complete: function() {
                        isRequestingOtp = false;
                        button.removeData('otpRequestPending');
                        button
                            .prop('disabled', false)
                            .html('Request OTP');
                    }
                });
            }
            $(document).on(
                'input',
                '.otp-input',
                function() {
                    const input = $(this);
                    input.val(
                        input
                        .val()
                        .replace(/\D/g, '')
                        .substring(0, 1)
                    );
                    if (input.val().length === 1) {

                        input
                            .next('.otp-input')
                            .focus();

                    }
                    updateOtp();

                }
            );
            $(document).on(
                'keydown',
                '.otp-input',
                function(e) {
                    if (
                        e.key === 'Backspace' &&
                        $(this).val() === ''
                    ) {
                        $(this)
                            .prev('.otp-input')
                            .focus();
                    }
                }
            );
            $(document).on(
                'keydown',
                '.otp-input',
                function(e) {
                    const input = $(this);
                    if (e.key === 'ArrowLeft') {
                        input
                            .prev('.otp-input')
                            .focus();

                    }
                    if (e.key === 'ArrowRight') {
                        input
                            .next('.otp-input')
                            .focus();

                    }
                }
            );
            $(document).on(
                'paste',
                '.otp-input',
                function(e) {
                    e.preventDefault();
                    const clipboard =
                        e.originalEvent.clipboardData ||
                        window.clipboardData;
                    const value =
                        clipboard
                        .getData('text')
                        .replace(/\D/g, '')
                        .substring(0, 6);
                    if (!value) {
                        return;
                    }
                    for (
                        let i = 0; i < value.length; i++
                    ) {

                        $('#otp_' + (i + 1))
                            .val(value[i]);

                    }
                    updateOtp();
                    $('#otp_' + value.length)
                        .focus();
                }
            );

            function updateOtp() {
                let otp = '';
                for (
                    let i = 1; i <= 6; i++
                ) {
                    otp += $('#otp_' + i).val();
                }
                $('#otp').val(otp);
            }
            $('#otpForm').validate({
                rules: {
                    otp: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    }
                },
                messages: {
                    otp: {
                        required: 'Please enter the OTP.',
                        digits: 'OTP must contain only numbers.',
                        minlength: 'OTP must be 6 digits.',
                        maxlength: 'OTP must be 6 digits.'
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback text-center',
                errorPlacement: function(error) {

                    $('#otpError')
                        .text(error.text())
                        .addClass('d-block');
                    error.remove();

                },
                highlight: function() {

                    $('.otp-input')
                        .addClass('is-invalid');

                },

                unhighlight: function() {

                    $('.otp-input')
                        .removeClass('is-invalid');
                    $('#otpError')
                        .empty()
                        .removeClass('d-block');

                },
                submitHandler: function(form, event) {

                    if (event) {
                        event.preventDefault();
                    }

                    if (isVerifyingOtp) {
                        return false;
                    }
                    updateOtp();
                    verifyOtp(form);
                    return false;

                }

            });

            function verifyOtp(form) {
                const button = $('#verifyOtpBtn');
                if (isVerifyingOtp || button.data('otpVerifyPending')) {
                    return;
                }
                updateOtp();
                isVerifyingOtp = true;
                button.data('otpVerifyPending', true);
                clearAlert('#otpAlert');
                button
                    .prop('disabled', true)
                    .html(`
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Verifying...
                `);
                $.ajax({
                    url: loginUrl,
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {

                        if (response.status !== 'success') {

                            showAlert(
                                '#otpAlert',
                                response.message ||
                                'Invalid OTP.',
                                'danger'
                            );

                            return;
                        }

                        showAlert(
                            '#otpAlert',
                            response.message ||
                            'OTP verified successfully.',
                            'success'
                        );
                        if (
                            response.data &&
                            response.data.redirect_to
                        ) {
                            setTimeout(function() {

                                window.location.href =
                                    response.data.redirect_to;
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(
                            xhr,
                            '#otpAlert'
                        );
                    },

                    complete: function() {
                        isVerifyingOtp = false;
                        button.removeData('otpVerifyPending');
                        button
                            .prop('disabled', false)
                            .html('Verify OTP');
                    }
                });
            }

            $('#resendOtpBtn').on(
                'click',
                function() {
                    const button = $(this);
                    if (isResendingOtp || button.data('otpResendPending')) {
                        return;
                    }
                    isResendingOtp = true;
                    button.data('otpResendPending', true);
                    clearAlert('#otpAlert');
                    button
                        .prop('disabled', true)
                        .html(`
                        <span class="spinner-border spinner-border-sm me-1"></span>
                        Sending...
                    `);
                    $.ajax({
                        url: loginUrl,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            action: 'resend_otp',
                            type: $('#otpType').val(),
                            identifier: $('#otpIdentifierValue').val()
                        },
                        dataType: 'json',

                        success: function(response) {
                            if (response.status !== 'success') {
                                showAlert(
                                    '#otpAlert',
                                    response.message ||
                                    'Unable to resend OTP.',
                                    'danger'
                                );
                                return;
                            }
                            resetOtp();

                            startResendCountdown();

                            $('#otp_1').focus();

                            showAlert(
                                '#otpAlert',
                                response.message ||
                                'OTP resent successfully.',
                                'success'
                            );

                        },

                        error: function(xhr) {

                            handleAjaxError(
                                xhr,
                                '#otpAlert'
                            );

                        },

                        complete: function() {

                            isResendingOtp = false;
                            button.removeData('otpResendPending');

                            button
                                .prop('disabled', false)
                                .html('Resend OTP');

                        }

                    });

                }
            );

            function startResendCountdown() {

                clearInterval(resendInterval);

                let seconds = resendSeconds;

                $('#resendTimer')
                    .removeClass('d-none');

                $('#resendOtpBtn')
                    .addClass('d-none')
                    .prop('disabled', false);

                $('#countdown')
                    .text(seconds);

                resendInterval = setInterval(
                    function() {
                        seconds--;
                        $('#countdown')
                            .text(seconds);
                        if (seconds <= 0) {
                            clearInterval(resendInterval);
                            $('#resendTimer')
                                .addClass('d-none');

                            $('#resendOtpBtn')
                                .removeClass('d-none')
                                .prop('disabled', false);
                        }
                    },
                    1000
                );
            }
            function resetOtp() {
                for (
                    let i = 1; i <= 6; i++
                ) {

                    $('#otp_' + i)
                        .val('')
                        .removeClass('is-invalid');

                }
                $('#otp')
                    .val('');
                clearAlert('#otpAlert');
                $('#otpError')
                    .empty()
                    .removeClass('d-block');
            }

            $('#changeLoginBtn').on(
                'click',
                function() {
                    clearInterval(resendInterval);
                    resetOtp();
                    $('#otpSection')
                        .addClass('d-none');
                    $('#loginSection')
                        .removeClass('d-none');
                    clearAlert('#loginAlert');
                    $('#identifier')
                        .focus();

                }
            );
            function showAlert(
                selector,
                message,
                type
            ) {
                const safeMessage =
                    $('<div>')
                    .text(message)
                    .html();
                $(selector).html(`
                <div
                    class="alert alert-${type} alert-dismissible fade show"
                    role="alert"
                >
                    ${safeMessage}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            `);
            }
            function clearAlert(selector) {

                $(selector).empty();

            }
            function handleAjaxError(
                xhr,
                alertSelector
            ) {
                if (xhr.status === 422) {
                    const errors =
                        xhr.responseJSON?.data?.errors || {};
                    if (alertSelector === '#otpAlert') {
                        const otpMessage = errors.otp?.[0] ||
                            xhr.responseJSON?.message;
                        if (otpMessage) {
                            showOtpError(otpMessage);
                        }
                        return;
                    }
                    $.each(
                        errors,
                        function(field, messages) {
                            const input =
                                $(`[name="${field}"]`);
                            if (input.length) {
                                input
                                    .addClass('is-invalid');
                                input
                                    .siblings('.invalid-feedback')
                                    .remove();
                                input.after(`
                                <div class="invalid-feedback">
                                    ${messages[0]}
                                </div>
                            `);
                            }
                        }
                    );
                    if (xhr.responseJSON?.message) {
                        showAlert(
                            alertSelector,
                            xhr.responseJSON.message,
                            'danger'
                        );
                    }
                    return;

                }
                showAlert(
                    alertSelector,
                    xhr.responseJSON?.message ||
                    'Something went wrong. Please try again.',
                    'danger'
                );

            }
            function showOtpError(message) {
                $('.otp-input')
                    .addClass('is-invalid');
                $('#otpError')
                    .text(message)
                    .addClass('d-block');
            }
            $('#identifier').focus();

        });
    </script>
@endpush
