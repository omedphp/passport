<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omed\Passport\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configureCors();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    private function configureCors(): void
    {
        $config = $this->app['config'];

        /** @var string $env */
        $env           = env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000,http://localhost');
        $allowedOrigins= explode(',', $env);
        $config->set('cors.allowed_origins', $allowedOrigins);
    }
}
