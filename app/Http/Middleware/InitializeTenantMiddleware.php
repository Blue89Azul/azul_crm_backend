<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantMiddleware
{

    public function __construct(
        protected Tenancy $tenancy
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accountName = $request->header("X-Account");

        if ($accountName && !$this->tenancy->initialized) {
            $this->tenancy->initialize($accountName);
        }

        return $next($request);
    }
}
