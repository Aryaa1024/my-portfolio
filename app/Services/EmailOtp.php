<?php

namespace App\Services;

use App\Models\Otp;
use Throwable;

class EmailOtp
{
    public function sendOtp(string $email, string $otp)
    {
        $email = strtolower(trim($email));

        try {
            $mailService = new MailService;
            $mailService->send(
                recipients: $email,
                subject: 'Your verification code',
                view: 'emails.otp',
                data: ['otp' => $otp],
            );
        } catch (Throwable) {

            return 'otpFailed';
        }

        return 'otpSent';
    }

    public function verifyOtp(string $email, string $otp): string
    {
        $otpRecord = Otp::query()
            ->where('type', 'email')
            ->where('identifier', strtolower(trim($email)))
            ->latest()
            ->first();

        if (! $otpRecord) {
            return 'noOtp';
        }

        if ($otpRecord->created_at->addMinutes(5)->isPast()) {
            return 'expiredOtp';
        }

        if (! hash_equals($otpRecord->otp, $otp)) {
            return 'wrongOtp';
        }

        $otpRecord->delete();

        return 'verifiedOtp';
    }
}
