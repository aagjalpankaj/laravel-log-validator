<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Middlewares;

use Aagjalpankaj\Lalo\Dto\TraceId;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TraceIdMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $headerName = 'x-trace-id';

        $requestId = $request->header($headerName) ?? TraceId::forWeb()->value;

        $request->headers->set($headerName, $requestId);

        $response = $next($request);

        $response->headers->set($headerName, $requestId);

        return $response;
    }
}
