<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('throw validation errors if user details are not sent', function () {
    expect(post('/api/auth/register', [], ['Accept' => 'application/json']))
        ->assertStatus(422);
});

it("check if we can register new user", function () {
    $user = [
        'first_name'            => 'test',
        'last_name'             => 'test',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];
    $response = post('/api/auth/register', $user);
    expect($response)
        ->assertStatus(200)
        ->and(User::count())->toBeOne();
});

it("check if user can login", function () {
    $user = User::factory()->create();

    $response = post('/api/auth/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);
    expect($response)
        ->assertSuccessful()
        ->and($response->json()['data'])
        ->toHaveKey('access_token');
});


it("logout logged in user", function () {
    $user = User::factory()->create();
    $response = post('/api/auth/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $logoutResponse = post('api/auth/logout', [], [
        'Accept'        => 'application/json',
        'Authorization' => 'Bearer '.$response->json()['data']['access_token'],
    ]);
    expect($logoutResponse)->assertSuccessful();
});
 
