<?php

namespace App\Providers;

use App\services\MailchimpNewsletter;
use App\services\Newsletter;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(Newsletter::class, function () {
            $client = (new ApiClient())->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us12'
            ]);

            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* For granting authorization for certain actions */
        /* Can be called like:
        
        if (Gate::allows('admin')) {
            // Do something
        }

        if (request()->user()->can('admin')) {
            // Do something
        }

        This one is for a CONTROLLER and if false, it will throw a 403 error instantly
        $this->authorize('admin');
        */
        Gate::define('admin', function(User $user) {
            return $user->username === 'martin-men';
        });

        /* Create my own blade directives */
        /* This one is of type IF and evaluates if the current user is admin */
        Blade::if('admin', function() {
            return request()->user()?->can('admin');
        });
    }
}
