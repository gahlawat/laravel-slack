<?php

namespace Gahlawat\Slack;

use Illuminate\Support\ServiceProvider;

class SlackServiceProvider extends ServiceProvider
{
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/slack.php' => config_path('slack.php'),
        ]);
    }

    protected function registerFacade()
    {
        $this->app->bind('gahlawat.slack', function ($app) {
            return new Slack();
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerFacade();
    }
}
