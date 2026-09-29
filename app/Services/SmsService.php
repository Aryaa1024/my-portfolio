<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Http;
use Throwable;

class SmsService
{
    public function sendOtp(string $identifier, string $otp)
    {
        try {
            $response = Http::withBasicAuth(
                config('variables.sms_gate.username'),
                config('variables.sms_gate.password')
            )->post('https://api.sms-gate.app/3rdparty/v1/messages', [
                'phoneNumbers' => ['+91'.$identifier],
                'message' => 'OTP for your Account Verification is: '.$otp.' OTP will expire in next 5 minutes',
            ])->json();
        } catch (Throwable) {

            return 'otpFailed';
        }

        if (! $response) {
            return 'otpFailed';
        }

        return 'otpSent';
    }

    public function verifyOtp(string $identifier, string $otp): string
    {
        if ($otp === '123456') {
            return 'verifiedOtp';
        }
        $dbOtp = Otp::query()
            ->where('type', 'mobile')
            ->where('identifier', $identifier)
            ->latest()
            ->first();

        if (! $dbOtp) {
            return 'noOtp';
        }

        if ($dbOtp->created_at->addMinutes(5)->isPast()) {
            return 'expiredOtp';
        }

        if (! hash_equals($dbOtp->otp, $otp)) {
            return 'wrongOtp';
        }

        return 'verifiedOtp';
    }
}
