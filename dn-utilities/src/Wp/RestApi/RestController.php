<?php

namespace DigitalNature\Utilities\Wp\RestApi;

use Exception;
use WP_REST_Controller;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class RestController extends WP_REST_Controller
{
    /**
     * @var RestControllerRoute[]
     */
    protected array $routes;

    /**
     * @var RestResource
     */
    public RestResource $resource;

    /**
     * @return string
     */
    public abstract function get_route_url(): string;

    /**
     * @return RestControllerRoute[]
     */
    protected abstract function get_routes(): array;

    /**
     * @return RestResource
     */
    protected abstract function get_resource(): RestResource;

    /**
     * @param RestNamespace $namespace
     * @throws Exception
     */
    public function __construct(RestNamespace $namespace)
    {
        $this->namespace = "{$namespace->get_name()}/{$namespace->get_version()}";
        $this->routes = $this->get_routes();
        $this->resource = $this->get_resource();
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

        return $route;
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
                'default' => $arg->default(),
                'required' => $arg->required(),
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
                'methods'               => $route->methods(),
                'callback'              => [$route, 'callback'],
                'permission_callback'   => [$route, 'permission_callback'],
                'args'                  => $this->build_args($route->args()),
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

    /**
     * @return void
     * @throws Exception
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            $this->build_route_url(),
            $this->build_route_configuration(),
        );
    }
}