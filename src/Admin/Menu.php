<?php

namespace DigitalNature\Utilities\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

use DigitalNature\Utilities\Common\Users\Capabilities\DigitalNatureMenuCapability;
use DigitalNature\Utilities\Config\PluginConfig;
use DigitalNature\WordPressUtilities\Factories\ModelFactory;
use DigitalNature\WordPressUtilities\Helpers\MessageHelper;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

class Menu
{
    const DIGITAL_NATURE_MENU_SLUG = 'digital-nature';
    const CACHE_FLUSH_URL = 'digital-nature/flush-cache';
    const MODEL_NOTES_URL = 'digital-nature/notes';
    const USER_NOTES_URL = 'digital-nature/user/notes';

    public function __construct()
    {
        add_action('admin_init', [$this, 'digital_nature_flush_cache_page'], 1);
        add_action('admin_menu', [$this, 'add_admin_menu'], 20);
    }

    /**
     * @return void
     */
    public function digital_nature_flush_cache_page()
    {
        // if it 's not the flush cache page then we skip it
        if (!isset($_GET['page']) || $_GET['page'] !== self::CACHE_FLUSH_URL) {
            return;
        }

        $key = $_GET['key'] ?? null;

        if (!$key) {
            return;
        }

        delete_transient($key);

        // send them back where they came from
        wp_safe_redirect(wp_get_referer());
        exit;
    }

    /**
     * Adds the menu items
     *
     * @return void
     */
    public function add_admin_menu(): void
    {
        add_menu_page(
            '',
            'Digital Nature',
            DigitalNatureMenuCapability::get_capability_name(),
            self::DIGITAL_NATURE_MENU_SLUG,
            [ $this, 'digital_nature_view' ],
            PluginConfig::get_plugin_url() . 'assets/admin/img/digital-nature-white-sml.png',
            2
        );

        /** MENU ITEMS */
        add_submenu_page(
            self::DIGITAL_NATURE_MENU_SLUG,
            'Digital Nature',
            'Dashboard',
            DigitalNatureMenuCapability::get_capability_name(),
            self::DIGITAL_NATURE_MENU_SLUG,
            [ $this, 'digital_nature_view' ],
            2
        );

        add_submenu_page(
            '',
            'Model Notes',
            'Model Notes',
            DigitalNatureMenuCapability::get_capability_name(),
            self::MODEL_NOTES_URL,
            [$this, 'digital_nature_model_notes_view']
        );

        add_submenu_page(
            '',
            'User Notes',
            'User Notes',
            DigitalNatureMenuCapability::get_capability_name(),
            self::USER_NOTES_URL,
            [$this, 'digital_nature_user_notes_view']
        );

        // CACHE FLUSHING PAGES
        add_submenu_page(
            '',
            'Cache Flush',
            'Cache Flush',
            'edit_pages',
            self::CACHE_FLUSH_URL,
            [$this, 'digital_nature_flush_cache_page']
        );
    }

    /**
     * @return void
     */
    public function digital_nature_view()
    {
        TemplateHelper::render(
            'dn-utilities/admin/home.php',
            [
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }


    /**
     * @return void
     */
    public function digital_nature_model_notes_view()
    {
        $modelId = $_GET['model'] ?? null;

        if (!$modelId) {
            MessageHelper::error_and_exit('You must submit a model to view the notes for. Go back and try again');
        }

        $model = ModelFactory::from_id($modelId);

        if (!$model) {
            MessageHelper::error_and_exit('No model was found with that ID. Go back and try again');
        }

        TemplateHelper::render(
            'dn-utilities/admin/model/notes.php',
            [
                'model' => $model,
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }

    /**
     * @return void
     */
    public function digital_nature_user_notes_view()
    {
        $userId = $_GET['user'] ?? null;

        if (!$userId) {
            MessageHelper::error_and_exit('You must submit a user to view the notes for. Go back and try again');
        }

        $user = get_user_by('ID', $userId);

        if (!$user) {
            MessageHelper::error_and_exit('No user was found with that ID. Go back and try again');
        }

        TemplateHelper::render(
            'dn-utilities/admin/user/notes.php',
            [
                'user' => $user,
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }
}