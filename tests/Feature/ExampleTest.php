<?php

it('returns homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
