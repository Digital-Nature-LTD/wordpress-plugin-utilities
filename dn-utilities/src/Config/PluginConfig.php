<?php

namespace DigitalNature\Utilities\Config;

use DigitalNature\WordPressUtilities\Config\PluginConfiguration;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class PluginConfig extends PluginConfiguration
{
    /**
     * @return string
     */
    public static function get_prefix(): string
    {
        return 'DIGITAL_NATURE_UTILITIES';
    }

    /**
     * @return string
     */
    public static function get_plugin_name(): string
    {
        return 'dn-utilities';
    }

    /**
     * @return string
     */
    public static function get_plugin_friendly_name(): string
    {
        return 'Digital Nature - Utilities';
    }

    /**
     * @return string
     */
    public static function get_plugin_text_domain(): string
    {
        return 'dn-utilities';
    }
}