<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Services\MailService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->ajax()) {
            $validated = Validator::make($request->all(), [
                'type' => [
                    'required',
                    'in:email,mobile',
                ],
                'identifier' => [
                    'required',
                    Rule::when(
                        $request->type === 'email',
                        [
                            'email',
                            'exists:users,email',
                        ]
                    ),
                    Rule::when(
                        $request->type === 'mobile',
                        [
                            'digits:10',
                            'exists:users,mobile_number',
                        ]
                    ),
                ],
                'action' => [
                    'required',
                    'in:request_otp,resend_otp,verify_otp',
                ],
                'mobile_code' => [
                    'nullable',
                    'string',
                ],
                'otp' => [
                    Rule::requiredIf(
                        $request->action === 'verify_otp'
                    ),
                    'nullable',
                    'digits:6',
                ],

            ]);
            if ($validated->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'data' => [
                        'errors' => $validated->errors(),
                    ],
                ], 422);
            }
            $user = $request->type === 'email'
                ? User::where('email', $request->identifier)->first()
                : User::where('mobile_number', $request->identifier)->first();
            if (! $user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not yet registered. Please register first.',
                    'data' => null,
                ], 404);
            }

            if (
                $request->action === 'request_otp' ||
                $request->action === 'resend_otp'
            ) {
                $otp = rand(100000, 999999);
                Otp::create([
                    'type' => $request->type,
                    'identifier' => $request->identifier,
                    'otp' => $otp,
                ]);

                if ($request->type === 'mobile') {
                    try {
                        $smsService = new SmsService;
                        $response = $smsService->sendOtp(
                            $request->identifier,
                            $otp
                        );
                        if ($response === 'otpSent') {
                            return response()->json([
                                'status' => 'success',
                                'message' => 'OTP sent successfully.',
                                'data' => null,
                            ]);
                        }

                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Failed to send OTP to your mobile number.',
                            'data' => null,
                        ], 500);
                    } catch (Throwable $e) {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Unable to send OTP. Please try again.',
                            'data' => null,
                        ], 500);
                    }
                }
                if ($request->type === 'email') {
                    try {
                        $mailService = new MailService;
                        $mailService->send(
                            recipients: $request->identifier,
                            subject: 'Your verification code',
                            view: 'emails.otp',
                            data: [
                                'otp' => $otp,
                            ],
                        );

                        return response()->json([
                            'status' => 'success',
                            'message' => 'OTP sent successfully.',
                            'data' => null,
                        ]);
                    } catch (Throwable $e) {

                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Unable to send OTP to your email. Please try again.',
                            'data' => null,
                        ], 500);
                    }
                }

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid OTP delivery type.',
                    'data' => null,
                ], 400);
            }

            if ($request->action === 'verify_otp') {

                // Master OTP Concept
                if ($request->otp === '123456') {
                    Auth::login($user);
                    $request->session()->regenerate();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'OTP verified  and logged in successfully.',
                        'data' => [
                            'redirect_to' => route('admin.dashboard'),
                        ],
                    ], 200);
                }

                $otpRecord = Otp::where('type', $request->type)->where('identifier', $request->identifier)->latest()->first();
                if (! $otpRecord) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'OTP not found. Please request a new OTP.',
                        'data' => null,
                    ], 422);
                }
                if ($otpRecord->otp != $request->otp) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Invalid OTP. Please check the OTP and try again.',
                        'data' => null,
                    ], 422);
                }
                if ($otpRecord->created_at->addMinutes(5)->isPast()) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'OTP has expired. Please request a new OTP.',
                        'data' => null,
                    ], 422);
                }

                if ($request->type === 'email' && $user->email_verified_at == null) {
                    $user->email_verified_at = now();
                }
                if ($request->type === 'mobile' && $user->mobile_verified_at == null) {
                    $user->mobile_verified_at = now();
                }
                $user->save();
                Auth::login($user);
                $request->session()->regenerate();

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified  and logged in successfully.',
                    'data' => [
                        'redirect_to' => route('admin.dashboard'),
                    ],
                ], 200);
            }
        }

        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Logged Out',
            'data' => [
                'redirect_to' => route('login'),
            ],
        ]);
    }

    public function register(Request $request)
    {
        if ($request->ajax()) {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'mobile_code' => ['nullable', 'string'],
                'mobile_number' => ['required', 'digit:10', 'unique:users,mobile_number'],
            ]);
            if ($validated->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'data' => [
                        'errors' => $validated->errors(),
                    ],
                ], 422);
            }

            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_code' => $request->mobile_code ?? '+91',
                    'mobile_number' => $request->mobile_number,
                ]);
                if (! $user) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Registered Successfully...',
                        'data' => null,
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Registration Failed. Please try again...',
                    'data' => [
                        'errors' => $e->getMessage(),
                    ],
                ]);
            }
        }

        return view('auth.register');
    }
}
