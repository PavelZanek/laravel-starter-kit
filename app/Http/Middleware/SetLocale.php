<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var array<array-key, string> $availableLocales */
        $availableLocales = config('project.available_locales');
        $locale = session('locale', config('app.locale'));

        abort_if(! in_array($locale, $availableLocales, true), 404);

        app()->setLocale($locale);

        return $next($request);
    }
}
