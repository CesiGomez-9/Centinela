<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // CSP adaptado para Bootstrap, Bootstrap Icons, Google Fonts y JS bundle
        $csp = "default-src 'self'; ".
            "script-src 'self' https://cdn.jsdelivr.net 'unsafe-inline'; ".
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; ".
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; ".
            "img-src 'self' data:; ".
            "connect-src 'self'; ".
            "frame-src 'none'; ".
            "base-uri 'self'; ".
            "form-action 'self'; ".
            "object-src 'none'; ".
            "worker-src 'self'; ".
            "manifest-src 'self';";

        // Establecemos la cabecera CSP
        $response->headers->set('Content-Security-Policy', $csp);

        // Otras cabeceras de seguridad recomendadas
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        return $response;
    }
}
