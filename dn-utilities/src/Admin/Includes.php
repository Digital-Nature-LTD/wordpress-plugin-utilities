<?php

namespace DigitalNature\Utilities\Admin;

// Exit if accessed directly.
use DigitalNature\Utilities\Config\PluginConfig;

if ( ! defined( 'ABSPATH' ) ) exit;

class Includes
{
    /**
     * constructor
     */
    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_scripts_and_styles'], 20);

        // construct any admin classes here
        new \DigitalNature\Utilities\Admin\Menu();
    }

    /**
     * Enqueue the backend related scripts and styles for this plugin.
     * All the added scripts and styles will be available on every page within the backend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_backend_scripts_and_styles()
    {
        wp_enqueue_style( 'dn-utilities-admin-styles', PluginConfig::get_plugin_url() . 'assets/admin/css/dn-utilities-admin.css', [], PluginConfig::get_plugin_version(), 'all' );

        wp_register_style('dn-utilities-google-fonts', '//fonts.googleapis.com/css2?family=Geist:wght@400..500&family=Instrument+Serif:ital@0;1&display=swap', [], null);
        wp_enqueue_style('dn-utilities-google-fonts');
    }
}
