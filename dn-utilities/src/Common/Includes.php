<?php

namespace DigitalNature\Utilities\Common;

use DigitalNature\Utilities\Common\Users\Roles\DigitalNatureAdminRole;
use DigitalNature\Utilities\Config\PluginConfig;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

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

        add_action('admin_footer', [$this, 'enqueue_web_component_templates'], 20);
        add_action('wp_footer', [$this, 'enqueue_web_component_templates'], 20);
    }

    /**
     * @return void
     */
    public function enqueue_common_scripts_and_styles()
    {
        // common styles - inc variables
        wp_enqueue_style(
            'dn-utilities-common-styles',
            PluginConfig::get_plugin_url() . 'assets/common/css/common.css',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );

        // window utilities script
	    wp_enqueue_script('wp-api');
	    wp_enqueue_script_module(
            'dn-utilities-common-window-utilities',
            PluginConfig::get_plugin_url() . 'assets/common/js/common.js',
            [],
            PluginConfig::get_plugin_version(),
            'all'
        );
    }

    /**
     * @return void
     */
    public function enqueue_web_component_templates()
    {
        TemplateHelper::render(
            PluginConfig::get_plugin_name() . '/common/web-components/templates/dismissable-message-component-template.php',
            [],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }


}
