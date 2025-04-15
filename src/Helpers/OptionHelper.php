<?php

namespace DigitalNature\Utilities\Helpers;

use DigitalNature\Utilities\Config\PluginConfig;
use DigitalNature\Utilities\Config\Setting;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class OptionHelper
{
    /**
     * @param Setting $setting
     * @return void
     */
    public static function render_configuration_page(Setting $setting): void
    {
        TemplateHelper::render(
            PluginConfig::get_plugin_name() . '/admin/option/configure.php',
            [
                'setting' => $setting
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }
}