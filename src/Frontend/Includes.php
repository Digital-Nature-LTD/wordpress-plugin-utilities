<?php

namespace DigitalNature\Utilities\Frontend;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct(){
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_frontend_scripts_and_styles'], 20 );

        // construct any frontend classes here
        // new \DigitalNature\Utilities\Frontend\YourClass();

        // SHORTCODES
        // new \DigitalNature\Utilities\Shortcodes\YourClass();
    }

    /**
     * Enqueue the frontend related scripts and styles for this plugin.
     * All of the added scripts and styles will be available on every page within the frontend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_frontend_scripts_and_styles() {
        wp_enqueue_style( 'dn-utilities-frontend-styles', DN_UTILITIES_PLUGIN_URL . 'assets/frontend/css/frontend-styles.css', [], DN_UTILITIES_VERSION, 'all' );
        wp_enqueue_script( 'dn-utilities-frontend-script', DN_UTILITIES_PLUGIN_URL . 'assets/frontend/js/frontend-script.js', [], DN_UTILITIES_VERSION, 'all' );
    }
}
