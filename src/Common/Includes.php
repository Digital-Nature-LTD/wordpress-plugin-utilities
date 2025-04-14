<?php

namespace DigitalNature\Utilities\Common;

use DigitalNature\Utilities\Common\Users\Roles\DigitalNatureAdminRole;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes
{
    /**
     * constructor
     */
    function __construct()
    {
        // Add role(s)
        DigitalNatureAdminRole::add_role();
    }
}
