<?php

describe('Car Testing', function () {
    it('Can get all data')->get('/api/cars')->assertStatus(200);
    it('Can show data', function () {
        $response = $this->get('/api/todos/', ["id", 123]);
        dd($response);
    });
});
