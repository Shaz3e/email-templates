<?php

namespace Shaz3e\EmailTemplates\Providers;

use Illuminate\Support\Facades\File;
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
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        // Load language files from the package
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'email-templates');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../views', 'email-templates');

        // Publish assets conditionally
        $this->publishAssets();
    }

    protected function publishAssets()
    {
        // Config
        $this->publishes([
            __DIR__.'/../config/email-templates.php' => config_path('email-templates.php'),
        ], 'email-templates-config');

        // Views
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/email-templates'),
        ], 'email-templates-view');

        // Language files
        $this->publishes([
            __DIR__.'/../lang' => resource_path('lang/vendor/email-templates'),
        ], 'email-templates-lang');

        // Publish migrations only if they don't already exist
        $globalSettingsMigrationExists = $this->migrationExists('create_email_global_settings_table.php');
        $emailTemplatesMigrationExists = $this->migrationExists('create_email_templates_table.php');

        if (! $globalSettingsMigrationExists) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_email_global_settings_table.php' => database_path('migrations/'.date('Y_m_d_His').'_create_email_global_settings_table.php'),
            ], 'email-templates-migration');
        }

        if (! $emailTemplatesMigrationExists) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_email_templates_table.php' => database_path('migrations/'.date('Y_m_d_His', strtotime('+1 second')).'_create_email_templates_table.php'),
            ], 'email-templates-migration');
        }
    }

    /**
     * Check if a migration already exists in the migrations directory.
     *
     * @param  string  $migrationName
     * @return bool
     */
    protected function migrationExists($migrationName)
    {
        $migrationsPath = database_path('migrations');
        $files = File::glob($migrationsPath.'/*_'.$migrationName);

        return ! empty($files);
    }
}
