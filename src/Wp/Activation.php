<?php

namespace DigitalNature\Utilities\Wp;

use DigitalNature\Utilities\Config\PluginConfig;
use DigitalNature\WordPressUtilities\Helpers\CustomPostTypeHelper;
use DigitalNature\WordPressUtilities\Models\Model;
use DigitalNature\WordPressUtilities\Models\ModelNote;
use DigitalNature\WordPressUtilities\Models\UserNote;
use Exception;

// Exit if accessed directly.
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
            add_action('init', [$this, 'register_expired_post_status'], 0);
            add_action('init', [$this, 'register_archived_post_status'], 0);
            add_action('init', [$this, 'register_model_note_post_type'], 0);
            add_action('init', [$this, 'register_user_note_post_type'], 0);
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


    /**
     * @return void
     */
    public function register_expired_post_status(): void
    {
        register_post_status(
            Model::STATUS_EXPIRED,
            [
                'label'                     => _x( 'Expired', 'post' ),
                'public'                    => false,
                'exclude_from_search'       => true,
                'show_in_admin_all_list'    => false,
                'show_in_admin_status_list' => false,
                'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
            ],
        );
    }

    /**
     * @return void
     */
    public function register_archived_post_status(): void
    {
        register_post_status(
            Model::STATUS_ARCHIVED,
            [
                'label'                     => _x( 'Archived', 'post' ),
                'public'                    => false,
                'exclude_from_search'       => true,
                'show_in_admin_all_list'    => false,
                'show_in_admin_status_list' => false,
                'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
            ],
        );
    }

    /**
     * Add the model note post type
     *
     * @return void
     * @throws Exception
     */
    public function register_model_note_post_type(): void
    {
        $labels = [
            'name'          => 'Model Note',
            'singular_name' => 'Model Note',
        ];

        $args = [
            'labels'             => $labels,
            'description'        => 'Model Note',
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => false,
            'show_in_menu'       => false,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'supports'           => [],
        ];

        // Register the custom post type
        CustomPostTypeHelper::register_post_type(ModelNote::class, $args);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function register_user_note_post_type(): void
    {
        $labels = [
            'name'          => 'User Note',
            'singular_name' => 'User Note',
        ];

        $args = [
            'labels'             => $labels,
            'description'        => 'User Note',
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => false,
            'show_in_menu'       => false,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'supports'           => [],
        ];

        // Register the custom post type
        CustomPostTypeHelper::register_post_type(UserNote::class, $args);
    }
}