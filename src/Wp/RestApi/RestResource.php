<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestResource
{
    /**
     * @example 'post'
     * @return string
     */
    public abstract function get_schema_title(): string;

    /**
     * @example 'object'
     * @return string
     */
    public abstract function get_schema_type(): string;

    /**
     * Property indexed array of configs e.g. ['content' => ['description' => 'The post description', 'type' => 'string']]
     *
     * @return array
     */
    public abstract function get_schema_properties(): array;

    /**
     * Formats the given data in the correct schema
     *
     * @param array $data
     * @return array
     */
    public abstract function format_response(array $data): array;
}