<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeLanguages = \App\Models\Language::where('status', 1)->pluck('code')->toArray();
        $fallback = count($activeLanguages) > 0 ? $activeLanguages[0] : config('app.fallback_locale', 'en');

        $locale = null;

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->locale && in_array($user->locale, $activeLanguages)) {
                $locale = $user->locale;
            } else {
                $locale = $fallback;
                $user->locale = $locale;
                $user->save();
            }
        } elseif (session()->has('locale') && in_array(session('locale'), $activeLanguages)) {
            $locale = session('locale');
        } else {
            $locale = $fallback;
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return $next($request);
    }
}
