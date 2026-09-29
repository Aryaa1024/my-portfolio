<?php

use App\Mail\CommonMail;
use App\Models\Otp;
use App\Services\EmailOtp;
use App\Services\MailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('an email otp is sent and can be verified once', function () {
    Mail::fake();

    $emailOtp = app(EmailOtp::class);

    expect($emailOtp->sendOtp('user@example.com'))->toBe('otpSent');

    $otp = Otp::query()->where('identifier', 'user@example.com')->value('otp');

    Mail::assertSent(CommonMail::class, function (CommonMail $mail): bool {
        return $mail->hasTo('user@example.com')
                && $mail->mailSubject === 'Your verification code'
                && $mail->templateView === 'emails.otp';
    });

    expect($emailOtp->verifyOtp('user@example.com', $otp))->toBe('verifiedOtp');
    expect(Otp::query()->where('identifier', 'user@example.com')->exists())->toBeFalse();
});

test('the mail service supports common delivery options', function () {
    Mail::fake();

    app(MailService::class)->send(
        recipients: 'recipient@example.com',
        subject: 'Monthly update',
        view: 'emails.otp',
        data: ['otp' => '123456'],
        options: [
            'from' => 'updates@example.com',
            'cc' => 'manager@example.com',
            'bcc' => ['audit@example.com'],
            'reply_to' => 'support@example.com',
            'tags' => ['updates'],
            'metadata' => ['campaign' => 'monthly'],
            'text_view' => 'emails.otp',
        ],
    );

    Mail::assertSent(CommonMail::class, function (CommonMail $mail): bool {
        return $mail->hasTo('recipient@example.com')
            && $mail->mailSubject === 'Monthly update'
            && $mail->fromAddress === 'updates@example.com'
            && $mail->ccAddresses === ['manager@example.com']
            && $mail->bccAddresses === ['audit@example.com']
            && $mail->replyToAddresses === 'support@example.com'
            && $mail->mailTags === ['updates']
            && $mail->mailMetadata === ['campaign' => 'monthly'];
    });
});
