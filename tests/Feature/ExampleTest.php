<?php

it('returns homepage', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
