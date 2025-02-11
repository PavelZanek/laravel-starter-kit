<?php

declare(strict_types=1);

use function Pest\Laravel\get;

beforeEach(function (): void {
    config()->set('app.locale', 'en');
});

it('switches the language', function (): void {
get(route('locale.switch', ['locale' => 'cs']))
->assertRedirect()
->assertSessionHas('locale', 'cs');
    });

it('does not switch the language for an invalid locale', function (): void {
get(route('locale.switch', ['locale' => 'invalid']))
->assertNotFound()
->assertSessionMissing('locale');
    });

it('redirect back to referer after switching the language', function (): void {
get(route('locale.switch', ['locale' => 'cs']), ['HTTP_REFERER' => 'http://localhost/registration'])
->assertRedirect('http://localhost/registration')
->assertSessionHas('locale', 'cs');
    });
