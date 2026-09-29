<?php

use App\Models\Otp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('a user can request and verify an email otp', function () {
    Mail::fake();
    $user = User::factory()->create();

    $this->postJson(route('website.login.request-otp'), [
        'identifier' => 'email',
        'email' => $user->email,
    ])->assertOk()->assertJsonPath('status', 'success');

    $otp = Otp::query()->where('identifier', $user->email)->value('otp');

    $this->postJson(route('website.login.verify-otp'), [
        'identifier' => 'email',
        'email' => $user->email,
        'otp' => $otp,
    ])->assertOk()
        ->assertJsonPath('status', 'success');

    $this->assertAuthenticatedAs($user);
    expect(Otp::query()->where('identifier', $user->email)->exists())->toBeFalse();
});

test('an incorrect otp is rejected', function () {
    Mail::fake();
    $user = User::factory()->create();

    $this->postJson(route('website.login.request-otp'), [
        'identifier' => 'email',
        'email' => $user->email,
    ])->assertOk();

    $this->postJson(route('website.login.verify-otp'), [
        'identifier' => 'email',
        'email' => $user->email,
        'otp' => '000000',
    ])->assertStatus(422)
        ->assertJsonPath('status', 'failed');

    $this->assertGuest();
});

test('a second otp request is throttled for one minute', function () {
    Mail::fake();
    $user = User::factory()->create();

    $payload = [
        'identifier' => 'email',
        'email' => $user->email,
    ];

    $this->postJson(route('website.login.request-otp'), $payload)
        ->assertOk();

    $this->postJson(route('website.login.request-otp'), $payload)
        ->assertStatus(429)
        ->assertJsonPath('status', 'throttled');

    expect(Otp::query()->where('identifier', $user->email)->count())->toBe(1);
});

test('a user can request and verify a mobile otp', function () {
    Http::fake([
        'https://api.sms-gate.app/*' => Http::response(['sent' => true]),
    ]);

    $user = User::factory()->create();
    $user->update([
        'mobile_code' => '+91',
        'mobile_number' => '9876543210',
    ]);

    $this->postJson(route('website.login.request-otp'), [
        'identifier' => 'mobile',
        'mobile' => '9876543210',
        'mobile_code' => '+91',
    ])->assertOk()->assertJsonPath('status', 'success');

    $otp = Otp::query()
        ->where('type', 'mobile')
        ->where('identifier', '+919876543210')
        ->value('otp');

    $this->postJson(route('website.login.verify-otp'), [
        'identifier' => 'mobile',
        'mobile' => '9876543210',
        'mobile_code' => '+91',
        'otp' => $otp,
    ])->assertOk()
        ->assertJsonPath('status', 'success');

    $this->assertAuthenticatedAs($user);
});
