<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestNamespace
{
    /**
     * @return string
     */
    public abstract function get_name(): string;

    /**
     * @return string
     */
    public abstract function get_version(): string;

    /**
     * @return RestController[]
     */
    public abstract function get_controllers(): array;

    public function __construct()
    {
        foreach($this->get_controllers() as $controller) {
            $controller->register_routes();
        }
    }
}