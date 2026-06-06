<?php

namespace App\Http\Middleware;

use App\Models\ActivityLogK;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddlewareK
{
    /**
     * Log authenticated user route access for audit purposes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && !$request->is('_debugbar/*')) {
            ActivityLogK::create([
                'user_id'    => $request->user()->id,
                'action'     => 'route.access',
                'model_type' => null,
                'model_id'   => null,
                'properties' => [
                    'method' => $request->method(),
                    'url'    => $request->path(),
                    'status' => $response->getStatusCode(),
                ],
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        }

        return $response;
    }
}
