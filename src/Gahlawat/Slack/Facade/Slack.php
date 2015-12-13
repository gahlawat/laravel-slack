<?php

namespace Gahlawat\Slack\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see Gahlawat\Slack\Slack
 */
class Slack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gahlawat.slack';
    }
}
