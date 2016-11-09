<?php

namespace Rry\Reminder;

use Illuminate\Support\ServiceProvider;

class ReminderServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the config file.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('reminder.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('reminder', function ($app)
        {
            return new Reminder($app->session, $app->config);
        });
    }

    /**
     * Get the services provider by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['reminder'];
    }
}
