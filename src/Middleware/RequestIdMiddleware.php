<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestIdMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $headerName = 'x-request-id';

        $requestId = $request->header($headerName) ?? uniqid('req-', true);

        $request->headers->set($headerName, $requestId);

        $response = $next($request);

        $response->headers->set($headerName, $requestId);

        return $response;
    }
}
