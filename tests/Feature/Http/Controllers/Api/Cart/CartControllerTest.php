<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

it("throws validation errors if no values given", function () {
    expect(post('/api/cart', [],
        ['Accept' => 'application/json']))->assertStatus(422);
});

it('get all cart', function () {
    $session_id = now()->timestamp;
    $cart = Cart::factory(10)->create(['session_id' => $session_id]);
    $response = get('/api/cart?session_id='.$session_id, []);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('data'))
        ->toHaveLength(10)
        ->and($response->json('data')[0])
        ->toEqual($cart->first()->toArray());
});

it('add item to cart', function () {
    $product = Product::factory()->create();
    $response = post('/api/cart/', [
        'product_id' => $product->id,
        'qty'        => 1,
    ], []);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray();
});

it('can update given cart', function () {
    $cart = Cart::factory()->create();

    $response = put('/api/cart/'.$cart->id, [
        'qty'        => 10,
        'product_id' => $cart->product_id,
    ], []);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray()
        ->and($response->json('data')['qty'])
        ->toBe(10);
});

it('can delete given cart', function () {
    $cart = Cart::factory()->create();
    $response = delete('/api/cart/'.$cart->id, [],
        []);

    expect($response)
        ->assertSuccessful();
});