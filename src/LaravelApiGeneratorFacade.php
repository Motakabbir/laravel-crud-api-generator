<?php

namespace Dolar\LaravelApiGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dolar\LaravelApiGenerator\LaravelApiGenerator
 */
class LaravelApiGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-api-generator';
    }
}
