<?php

describe('Car Testing', function () {
    it('Can get all data')->get('/api/cars')->assertStatus(200);
    it('Can show data', function () {
        $attribute = \App\Models\Car::factory();
        $response = $this->getJson("/api/cars/{$attribute->id}");
        $response->assertStatus(200);
    });
});
