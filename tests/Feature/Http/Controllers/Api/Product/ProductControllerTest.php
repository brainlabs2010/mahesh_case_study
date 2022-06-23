<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

it('without login can not access products endpoint', function () {
    expect(get('/api/products', ['Accept' => 'application/json']))->assertStatus(401);
});

it("throws validation errors if no values given", function () {
    expect(post('/api/products', [],
        ['Accept' => 'application/json', 'Authorization' => 'Bearer '.loginUser()['access_token']]))->assertStatus(422);
});

it('get all products', function () {
    $products = Product::factory(10)->create()->each(fn($product) => $product->load('category'));
    $response = get('/api/products', ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json(['data']))
        ->and($response->json(['data'])['total'])
        ->toBe(10)
        ->and($response->json('data')['data'][0])
        ->toEqual($products->first()->toArray());
});

it('get single product', function () {
    $product = Product::factory()->create();
    $product->load('category');
    $response = get('/api/products/'.$product->id, ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('data'))
        ->toEqual($product->toArray());
});

it('can create new product', function () {
    $category = Category::factory()->create();
    $response = post('/api/products/', [
        'name'          => 'product name',
        'description'   => 'some description',
        'price'         => 200,
        'product_image' => UploadedFile::fake()->image('product.jpg'),
        'category_id'   => $category->id,
    ], ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray()
        ->and($response->json('data')['slug'])
        ->toBe('product-name');
});

it('can update given product', function () {
    $product = Product::factory()->create();
    $product->load('category');
    $response = put('/api/products/'.$product->id, [
        'name'        => 'product name',
        'description' => 'some description',
        'price'       => 500,
        'category_id' => $product->category_id,
    ], ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray()
        ->and($response->json('data')['name'])
        ->toBe('product name')
        ->and($response->json('data')['price'])
        ->toBe(500);
});

it('can delete given product', function () {
    $product = Product::factory()->create();
    $response = delete('/api/products/'.$product->id, [], ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful();
});