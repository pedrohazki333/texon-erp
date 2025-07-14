<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard route returns summary data', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200)
        ->assertViewHasAll([
            'customerCount',
            'productCount',
            'orderCount',
            'ordersByStatus',
            'pendingDeliveryOrders',
            'pendingDeliveryCount',
        ]);
});
