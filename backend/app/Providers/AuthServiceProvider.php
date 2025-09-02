<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Aquí puedes mapear modelos a políticas si usas policies
        // 'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Ejemplo de Gate si quieres definir permisos manuales
        // Gate::define('admin-only', function ($user) {
        //     return $user->role === 'admin';
        // });
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
