<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    private const SUPPORTED_LOCALES = ['en', 'ar'];

    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, self::SUPPORTED_LOCALES, strict: true)) {
            abort(400, 'Unsupported locale.');
        }

        session(['locale' => $locale]);

        return redirect()->back()->withHeaders([
            'Vary' => 'Accept-Language',
        ]);
    }
}
