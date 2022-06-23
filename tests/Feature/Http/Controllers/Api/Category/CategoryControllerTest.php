<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

it('without login can not access categories endpoint', function () {
    expect(get('/api/categories', ['Accept' => 'application/json']))->assertStatus(401);
});

it("throws validation errors if no values given", function () {
    expect(post('/api/categories', [],
        ['Accept' => 'application/json', 'Authorization' => 'Bearer '.loginUser()['access_token']]))->assertStatus(422);
});

it('get all categories', function () {
    $category = Category::factory(10)->create();
    $response = get('/api/categories', ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json(['data']))
        ->and($response->json(['data'])['total'])
        ->toBe(10)
        ->and($response->json('data')['data'][0])
        ->toEqual($category->first()->toArray());
});

it('get single category', function () {
    $category = Category::factory()->create();
    $response = get('/api/categories/'.$category->id, ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('data'))
        ->toEqual($category->toArray());
});

it('can create new category', function () {
    $response = post('/api/categories/', [
        'name' => 'category name',
    ], ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray()
        ->and($response->json('data')['slug'])
        ->toBe('category-name');
});

it('can update given category', function () {
    $category = Category::factory()->create();
    $response = put('/api/categories/'.$category->id, [
        'name' => 'category 1',
    ], ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful()
        ->and($response->json('success'))
        ->toBeTrue()
        ->and($response->json(['data']))
        ->toBeArray()
        ->and($response->json('data')['name'])
        ->toBe('category 1');
});

it('can delete given category', function () {
    $category = Category::factory()->create();
    $response = delete('/api/categories/'.$category->id, [],
        ['Authorization' => 'Bearer '.loginUser()['access_token']]);

    expect($response)
        ->assertSuccessful();
});