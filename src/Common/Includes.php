<?php

namespace DigitalNature\Utilities\Common;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * Here, create 'new' instances of all classes that create hooks/shortcodes/filters/api etc.
     *
     * constructor
     */
    function __construct()
    {
        // CRON
        // new \DigitalNature\Utilities\Cron\YourClass();

        // HOOKS
        // new \DigitalNature\Utilities\Hooks\YourClass();

        // REST
        new \DigitalNature\Utilities\Wp\Api\WPRest();

        // Late loading
        add_action('plugins_loaded', [$this, 'create_instances_after_all_plugins_loaded']);
    }

    /**
     * Here, create 'new' instances of all config classes that require other classes (e.g. the
     * hooks/shortcodes/filters/api etc. initialised in the constructor) before they can be initialised
     *
     * @return void
     */
    public function create_instances_after_all_plugins_loaded()
    {
        // CONFIG
        // new \DigitalNature\Utilities\Config\YourClass();
    }
}
