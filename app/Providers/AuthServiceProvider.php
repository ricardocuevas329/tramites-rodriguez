<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

// use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        VerifyEmail::toMailUsing(function($notifiable, $url){
            return (new MailMessage)
                ->subject(Lang::get('Verificar Dirección de Correo'))
                ->line(Lang::get('Haga clic en el botón de abajo para verificar su dirección de correo electrónico.'))
                ->action(Lang::get('Verificar la dirección de correo electrónico'), $url)
                ->line(Lang::get('Si no ha creado una cuenta, no es necesario que haga nada..'))
                ->salutation("Muchas Gracias!");

        });

       /* Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });*/
    }
}
