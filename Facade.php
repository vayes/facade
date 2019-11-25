<?php

namespace Vayes\Facade;

abstract class Facade
{
    /**
     * @var array
     */
    protected static $resolvedInstances = array();

    /**
     * Returns Namespace of requested Class
     *
     * e.g. return RequestFacade::class;
     *
     * @return string
     */
    abstract protected static function getFacadeAccessor(): string;

    /**
     * Returns Related Facade Instance
     * @return mixed
     */
    private static function getFacadeRoot()
    {
        $name = static::getFacadeAccessor();

        if (empty(static::$resolvedInstances[$name]))
        {
            static::$resolvedInstances[$name] = static::resolveFacadeInstance();
        }

        return static::$resolvedInstances[$name];
    }

    /**
     * Creates an instance for requested Class
     * @return mixed
     */
    private static function resolveFacadeInstance()
    {
        $name = static::getFacadeAccessor();
        return new $name();
    }

    /**
     * Simulates method calls
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic(string $method, $args)
    {
        $instance = static::getFacadeRoot();

        switch (count($args)) {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            case 5:
                return $instance->$method($args[0], $args[1], $args[2], $args[3], $args[4]);

            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }
}
