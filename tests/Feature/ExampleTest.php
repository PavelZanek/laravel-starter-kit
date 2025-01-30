<?php

declare(strict_types=1);

it('returns homepage', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
