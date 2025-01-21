<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('lang') && $request->header('lang') == 'en') {
            app()->setLocale('en');
        } else {
            app()->setLocale('ar'); // Set default locale to 'ar'
        }
        return $next($request);
    }
}
