<?php

namespace DigitalNature\Utilities\Common;

use DigitalNature\Utilities\Common\Users\Roles\DigitalNatureAdminRole;
use DigitalNature\Utilities\Config\PluginConfig;

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

        add_action('admin_enqueue_scripts', [$this, 'enqueue_common_scripts_and_styles'], 20);
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_common_scripts_and_styles'], 20 );
    }

    /**
     * @return void
     */
    public function enqueue_common_scripts_and_styles()
    {
        // web components
        wp_enqueue_script(
            'dn-utilities-component-grid-overlay',
            PluginConfig::get_plugin_url() . 'assets/common/js/web-components/digital-nature-grid-overlay-component.js',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );

        wp_enqueue_script(
            'dn-utilities-component-grid-overlay-cell',
            PluginConfig::get_plugin_url() . 'assets/common/js/web-components/digital-nature-grid-overlay-cell-component.js',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );

        // common styles - inc variables
        wp_enqueue_style(
            'dn-utilities-common-styles',
            PluginConfig::get_plugin_url() . 'assets/common/css/dn-utilities-common.css',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );

        // web component styles
        wp_enqueue_style(
            'dn-utilities-component-styles',
            PluginConfig::get_plugin_url() . 'assets/common/css/dn-utilities-web-components.css',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );
    }


}
