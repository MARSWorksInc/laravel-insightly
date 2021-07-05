<?php

namespace Marsworksinc\LaravelInsightly;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MarsworksInc\LaravelInsightly\LaravelInsightly
 */
class LaravelInsightlyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'insightly';
    }
}
