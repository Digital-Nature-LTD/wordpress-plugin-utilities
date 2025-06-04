<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\Utilities\Config\PluginConfig;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;


abstract class RestControllerRoute
{
    /**
     * @var RestController
     */
    protected RestController $controller;

    /**
     * @var RestArg[]
     */
    protected array $args = [];

    /**
     * @var WP_Error[]|WP_REST_Response[]
     */
    protected array $responseData = [];

    /**
     * @param RestController $controller
     */
    public function __construct(RestController $controller)
    {
        $this->controller = $controller;
        $this->args = $this->set_args();
    }

    /**
     * @return array
     */
    public abstract function methods(): array;

    /**
     * The callback return value is converted to JSON, and returned to the client
     *
     * @param WP_REST_Request $request
     * @return WP_Error|WP_REST_Response
     */
    public abstract function callback(WP_REST_Request $request);

    /**
     * @param WP_REST_Request $request
     * @return bool|WP_Error
     */
    public function permission_callback(WP_REST_Request $request)
    {
        // by default, we grant permission.
        return true;
    }

    /**
     * @return RestArg[]
     */
    public abstract function set_args(): array;

    /**
     * @return RestArg[]
     */
    public function args(): array
    {
        return $this->args;
    }

    /**
     * @param WP_REST_Request $request
     * @return array
     */
    protected function get_submitted_args(WP_REST_Request $request): array
    {
        $submitted = [];

        foreach ($this->args as $arg) {
            $value = $request->get_param($arg->get_name()) ?? $arg->default();

            if (is_null($value)) {
                continue;
            }

            $submitted[$arg->get_name()] = $value;
        }

        return $submitted;
    }

    /**
     * @param RestResourceModel $model
     * @param bool $addLink
     * @return WP_Error|WP_REST_Response
     */
    protected function add_response_data(RestResourceModel $model, bool $addLink = false)
    {
        $formattedResponse = $model->format_response();

        // get the response for this record
        $response = rest_ensure_response($formattedResponse);

        if (!is_wp_error($response) && $addLink) {
            $this->responseData[] = $this->response_with_links($response);
        } else {
            // add this record to the response data
            $this->responseData[] = $response->get_data();
        }

        return $response;
    }

    /**
     * @return WP_Error|WP_REST_Response
     */
    protected function send_response()
    {
        return rest_ensure_response($this->responseData);
    }

    /**
     * @return WP_REST_Response
     */
    protected function send_empty_response(): WP_REST_Response
    {
        return rest_ensure_response([]);
    }

    /**
     * @param string $message
     * @param string|null $code
     * @param int $httpStatus
     * @return WP_Error
     */
    protected function send_error_response(string $message, string $code = null, int $httpStatus = 400): WP_Error
    {
        return new WP_Error($code, esc_html__($message, PluginConfig::get_plugin_text_domain()), ['status' => $httpStatus]);
    }

    /**
     * @param WP_REST_Response $response
     * @return array
     */
    private function response_with_links(WP_REST_Response $response): array
    {
        $data = (array) $response->get_data();
        $server = rest_get_server();

        if ( method_exists( $server, 'get_compact_response_links' ) ) {
            $links = call_user_func( array( $server, 'get_compact_response_links' ), $response );
        } else {
            $links = call_user_func( array( $server, 'get_response_links' ), $response );
        }

        if ( ! empty( $links ) ) {
            $data['_links'] = $links;
        }

        return $data;
    }
}