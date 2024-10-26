<?php

namespace Shaz3e\EmailTemplates\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class EmailTemplatesServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Shaz3e\EmailTemplates\Console\Commands\CreateEmailTemplate::class,
            ]);
        }
    }

    public function boot()
    {
        // Register Livewire components
        Livewire::component('email-template-list', \Shaz3e\EmailTemplates\App\Livewire\EmailTemplates\EmailTemplateList::class);

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load language files from the package
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'email-templates');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../views', 'email-templates');


        // Publish configuration and assets (optional)
        $this->publishes([
            // Config
            __DIR__ . '/../config/email-templates.php' => config_path('email-templates.php'),
            // Views
            __DIR__ . '/../views' => resource_path('views/vendor/email-templates'),
            // Database
            __DIR__ . '/../database/migrations' => database_path('migrations'),

            // Language
            __DIR__ . '/../lang' => resource_path('lang/vendor/email-templates'),
        ], 'email-templates-all');

        // Publish configuration and assets (optional)
        $this->publishes([
            // Config
            // php artisan vendor:publish --tag=email-templates-config
            __DIR__ . '/../config/email-templates.php' => config_path('email-templates.php'),
        ], 'email-templates-config');

        // Publish views (optional)
        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/email-templates')
        ], 'email-templates-view');

        // Publish migrations (optional)
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'email-templates-migration');

        // Publish Language (optional)
        $this->publishes([
            __DIR__ . '/../lang' => resource_path('lang/vendor/email-templates'),
        ], 'email-templates-lang');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/email-templates.php',
            'email-templates'
        );
    }
}
