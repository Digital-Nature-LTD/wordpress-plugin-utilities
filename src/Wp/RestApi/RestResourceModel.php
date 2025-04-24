<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestResourceModel
{
    /**
     * @param array $data
     */
    public abstract function __construct(array $data = []);

    /**
     * Formats the resource in the correct schema
     *
     * @return array
     */
    public abstract function format_response(): array;
}