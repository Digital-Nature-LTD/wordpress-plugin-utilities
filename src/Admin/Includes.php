<?php

namespace DigitalNature\Utilities\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct(){
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_backend_scripts_and_styles'], 20 );

        // construct any admin classes here
        // new \DigitalNature\Utilities\Admin\YourClass();

        // SHORTCODES
        // new \DigitalNature\Utilities\Shortcodes\YourClass();
    }

    /**
     * Enqueue the backend related scripts and styles for this plugin.
     * All of the added scripts and styles will be available on every page within the backend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_backend_scripts_and_styles() {
        wp_enqueue_style( 'dn-utilities-admin-styles', DN_UTILITIES_PLUGIN_URL . 'assets/admin/css/admin-styles.css', [], DN_UTILITIES_VERSION, 'all' );
        wp_enqueue_script( 'dn-utilities-admin-script', DN_UTILITIES_PLUGIN_URL . 'assets/admin/js/admin-script.js', [], DN_UTILITIES_VERSION, 'all' );
    }
}
