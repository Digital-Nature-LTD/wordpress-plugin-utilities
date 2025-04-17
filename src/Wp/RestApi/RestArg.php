<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestArg
{
    protected $default;
    protected bool $required;

    /**
     * @param $required
     * @param $default
     */
    public function __construct($required = false, $default = null)
    {
        $this->default = $default;
        $this->required = $required;
    }

    /**
     * @return string
     */
    public abstract function get_name(): string;

    /**
     * Used as the default value for the argument, if none is supplied.
     *
     * @return null|mixed
     */
    public function default()
    {
        return $this->default ?? null;
    }

    /**
     * If defined as true, and no value is passed for that argument, an error will be returned. No effect if
     * a default value is set, as the argument will always have a value.
     *
     * @return null|mixed
     */
    public function required(): bool
    {
        return $this->required ?? false;
    }

    /**
     * Used to pass a function that will be passed the value of the argument. That function should return
     * true if the value is valid, and false if not.
     *
     * @param $param
     * @param $request
     * @param $key
     * @return bool
     */
    public function validate_callback($param, $request, $key): bool
    {
        return true;
    }

    /**
     * Used to pass a function that is used to sanitize the value of the argument before passing it to
     * the main callback.
     *
     * @param $value
     * @return mixed
     */
    public function sanitize_callback($value)
    {
        return $value;
    }
}