<?php

describe('Car Testing', function () {
    it('Can get all data')->get('/api/cars')->assertStatus(200);
    it('Can show data', function () {
        $attribute = \App\Models\Car::factory()->create();
        $response = $this->getJson("/api/cars/{$attribute->id}");
        $response->assertStatus(200)->assertJson(['data' => ['id' => $attribute->id]]);
    });
    it('Does not find data', function () {
        $response = $this->getJson("/api/cars/1");
        $response->assertStatus(404)->assertJson(['meta' => ['message' => "Data not found"]]);
    });
    it('Can create new car', function () {
        $attribute = \App\Models\Car::factory()->raw();
        $response = $this->postJson("/api/cars", $attribute);
        $response->assertStatus(201);
    })->todo('Generate Image');
    it('Can create new car', function () {
        $attribute = \App\Models\Car::factory()->raw();
        $response = $this->postJson("/api/cars", $attribute);
        $response->assertStatus(201);
    })->todo('Generate Image');
});
