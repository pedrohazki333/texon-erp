<?php

test('dashboard route returns summary data', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertViewHasAll([
            'customerCount',
            'productCount',
            'orderCount',
            'ordersByStatus',
        ]);
});
