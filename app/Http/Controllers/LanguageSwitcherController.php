<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class LanguageSwitcherController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        /** @var string[] $availableLocales */
        $availableLocales = config('project.available_locales');

        abort_if(! in_array($locale, $availableLocales, true), 404);

        app()->setLocale($locale);

        $request->session()->put('locale', $locale);

        return redirect()->to($request->header('referer') ?? '/');
    }
}
