<?php

namespace DigitalNature\Utilities\Wp\RestApi;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;


abstract class RestControllerRoute
{
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
    public abstract function args(): array;
}