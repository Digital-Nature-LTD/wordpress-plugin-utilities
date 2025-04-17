<?php

namespace DigitalNature\Utilities\Wp\RestApi;

use Exception;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestController extends WP_REST_Controller
{
    /**
     * @var string
     */
    protected string $version;

    /**
     * @return string
     */
    public abstract function get_route_url(): string;

    /**
     * @return RestControllerRoute[]
     */
    public abstract function get_routes(): array;

    /**
     * @return RestResource
     */
    public abstract function get_resource(): RestResource;

    /**
     * @param RestNamespace $namespace
     * @throws Exception
     */
    public function __construct(RestNamespace $namespace)
    {
        // add namespace
        $this->namespace = $namespace->get_name();
        $this->version = $namespace->get_version();
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function build_route_url(): string
    {
        $route = $this->get_route_url();

        // ensure route starts with a slash
        if (substr($route, 0, 1) !== '/') {
            throw new Exception("API routes must start with a '/' character.");
        }

        return "{$this->namespace}/{$this->version}{$route}";
    }

    /**
     * @param RestArg[] $arguments
     * @return array
     */
    protected function build_args(array $arguments): array
    {
        $args = [];

        foreach ($arguments as $arg) {
            $args[$arg->get_name()] = array_filter([
                'default' => [$arg, 'default'],
                'required' => [$arg, 'required'],
                'validate_callback' => [$arg, 'validate_callback'],
                'sanitize_callback' => [$arg, 'sanitize_callback'],
            ]);
        }

        return $args;
    }

    /**
     * @return array
     */
    protected function build_schema(): array
    {
        // get the resource type that we're returning
        $resource = $this->get_resource();

        return [
            // This tells the spec of JSON Schema we are using
            '$schema'              => $this->get_json_schema(),
            // The title property marks the identity of the resource.
            'title'                => $resource->get_schema_title(),
            'type'                 => $resource->get_schema_type(),
            // In JSON Schema you can specify object properties in the properties attribute.
            'properties'           => $resource->get_schema_properties(),
        ];
    }

    /**
     * @return array
     */
    public function build_route_configuration(): array
    {
        $routes = $this->get_routes();

        $config = [];

        foreach ($routes as $route) {
            $config[] = [
                array_filter(
                    [
                        'methods'               => $route->methods(),
                        'callback'              => [$route, 'callback'],
                        'permission_callback'   => [$route, 'permission_callback'],
                        'args'                  => $this->build_args($route->args()),
                    ]
                ),
                'schema' => $this->build_schema()
            ];
        }

        return $config;
    }

    /**
     * This tells the spec of JSON Schema we are using which is draft 4.
     *
     * @return string
     */
    protected function get_json_schema(): string
    {
        return 'http://json-schema.org/draft-04/schema#';
    }
}