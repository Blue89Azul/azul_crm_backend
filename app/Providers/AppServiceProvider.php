<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Routes resolution
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            })
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $tenantAuth = SecurityScheme::apiKey("header", "X-Tenant");
                $bearerAuth = SecurityScheme::http("Bearer");

                $openApi->secure($tenantAuth);
                $openApi->secure($bearerAuth);
            });
    }
}
