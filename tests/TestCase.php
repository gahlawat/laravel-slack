<?php

namespace Gahlawat\Slack\Tests;

use Gahlawat\Slack\Facade\Slack;
use Gahlawat\Slack\SlackServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [SlackServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Slack' => Slack::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']['slack'] = require __DIR__ . '/../config/slack.php';
    }
}
