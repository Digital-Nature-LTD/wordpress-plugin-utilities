<?php

namespace DigitalNature\Utilities\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct()
    {
        // construct any admin classes here
        new \DigitalNature\Utilities\Admin\Menu();
    }
}
