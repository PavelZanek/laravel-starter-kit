<?php

declare(strict_types=1);

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

it('sets the locale from the session', function (): void {
    $expectedLocale = 'cs';
    session()->put('locale', $expectedLocale);

    $request = Request::create('/test');
    $middleware = new SetLocale;

    $response = $middleware->handle($request, fn (Request $req): Response => new Response('OK'));

    expect(app()->getLocale())->toBe($expectedLocale)
        ->and($response->getContent())->toBe('OK');
});

it('falls back to the default app locale if session locale is not set', function (): void {
    session()->forget('locale');
    $defaultLocale = 'en';
    config()->set('app.locale', $defaultLocale);

    $request = Request::create('/test');
    $middleware = new SetLocale;

    $response = $middleware->handle($request, fn (Request $req): Response => new Response('OK'));

    expect(app()->getLocale())->toBe($defaultLocale)
        ->and($response->getContent())->toBe('OK');
});

it('returns 404 if the locale is invalid', function (): void {
    session()->put('locale', 'invalid-locale');
    config()->set('project.available_locales', ['en', 'cs']);

    $request = Request::create('/test');
    $middleware = new SetLocale;

    $middleware->handle($request, fn (Request $req): Response => new Response('OK'));
})->throws(Symfony\Component\HttpKernel\Exception\HttpException::class)->only();
