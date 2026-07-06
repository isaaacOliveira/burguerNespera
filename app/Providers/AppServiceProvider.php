<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate; // Mantém a Gate que está na image_4.png
use Illuminate\Support\Facades\Schema; // ADICIONADO: Importação do Schema para as migrações

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
           // Força o uso de HTTPS se o site não estiver a rodar em localhost
    if (config('app.env') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        URL::forceScheme('https');
    }
    
    // 1. Resolve o erro de chave longa das migrações (SQLSTATE[42000])
        Schema::defaultStringLength(191);

        // 2. Mantém a verificação de segurança para o Administrador (image_4.png)
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}

