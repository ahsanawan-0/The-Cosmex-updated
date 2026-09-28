<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves every public page from exactly one URL.
 *
 * On the live host the app sits behind a root .htaccess that rewrites into
 * public/, which makes the whole site reachable at /public/…, /index.php and
 * www. as well. Those copies are 301-redirected here to APP_URL + path, and
 * framework endpoints are kept out of search results.
 */
class CanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production') && $request->isMethodSafe()) {
            $root = rtrim((string) config('app.url'), '/');
            $host = parse_url($root, PHP_URL_HOST);
            $path = $request->getPathInfo();

            $wrongHost = $host && strcasecmp($request->getHost(), $host) !== 0;
            // Non-empty when the request came in as /public/… or /index.php.
            $wrongBase = $request->getBaseUrl() !== '';
            $trailingSlash = $path !== '/' && str_ends_with($path, '/');

            if ($wrongHost || $wrongBase || $trailingSlash) {
                $query = $request->getQueryString();
                $target = $root . ($trailingSlash ? rtrim($path, '/') : $path) . ($query ? '?' . $query : '');

                return redirect()->to($target, 301);
            }
        }

        $response = $next($request);

        if ($request->is('up', 'login', 'logout', 'admin', 'admin/*')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
