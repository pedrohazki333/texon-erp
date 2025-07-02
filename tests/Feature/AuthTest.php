<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'jogador1',
        'email' => 'jogador1@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('users', ['name' => 'jogador1']);
    $this->assertAuthenticated();
});

test('user can login', function () {
    $user = User::create([
        'name' => 'player',
        'email' => 'player@example.com',
        'password' => 'password',
    ]);

    $response = $this->post('/login', [
        'name' => 'player',
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});
