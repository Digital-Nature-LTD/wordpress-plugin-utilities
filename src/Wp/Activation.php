<?php

namespace DigitalNature\Utilities\Wp;

// Exit if accessed directly.
use DigitalNature\Utilities\Config\PluginConfig;

if ( ! defined( 'ABSPATH' ) ) exit;

class Activation
{
    private array $pluginsRequired = [
        // below is an example, this is obviously checking itself so not for real use
        // the key is just a label, the value is the path to the plugin file used in is_plugin_active()
        // 'Digital Nature Skeleton' => 'dn-utilities/dn-utilities.php',
    ];

    public function __construct() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if ($this->requirementsMet()) {
            register_activation_hook(PluginConfig::get_plugin_file(), [$this, 'register_activation_hook']);

            // include the custom settings for this plugin
            // new \DigitalNature\Utilities\Config\Settings();
        } else {
            deactivate_plugins(PluginConfig::get_plugin_base());
            add_action('network_admin_notices',[$this, 'activation_requirements_not_met']);
            register_activation_hook(PluginConfig::get_plugin_file(), [$this, 'activation_requirements_not_met']);
        }
    }

    /**
     * @return void
     */
    public function register_activation_hook() {
        // @TODO Add any tasks to run when the plugin is activated
    }

    /**
     * @return bool
     */
    private function requirementsMet(): bool
    {
        $allPluginsActive = true;

        foreach($this->pluginsRequired as $label => $path) {
            if (!is_plugin_active($path)) {
                $allPluginsActive = false;
                break;
            }
        }

        return $allPluginsActive;
    }

    /**
     * @return void
     */
    public function activation_requirements_not_met()
    {
        $requiredPlugins = implode(', ', array_keys($this->pluginsRequired));
        $message = "Plugin requirements not met, please ensure '$requiredPlugins' plugins are active before activating " . DIGITAL_NATURE_UTILITIES_FRIENDLY_NAME;

        echo "<div class='notice notice-error'><p>$message</p></div>";

        @trigger_error(__($message, 'cln'), E_USER_ERROR);
    }
}