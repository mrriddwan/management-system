<?php


namespace App\Actions;

abstract class ActionMaster
{
    protected static $instance;

    /**
     * Get the instance of the extending action class.
     *
     * @return static
     */
    public static function access()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}

