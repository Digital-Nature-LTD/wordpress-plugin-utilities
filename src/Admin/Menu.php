<?php

namespace DigitalNature\Utilities\Admin;

use DigitalNature\Utilities\Common\Users\Capabilities\DigitalNatureMenuCapability;
use DigitalNature\Utilities\UtilitiesConfig;
use DigitalNature\WordPressUtilities\Factories\ModelFactory;
use DigitalNature\WordPressUtilities\Helpers\MessageHelper;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

class Menu
{
    const CACHE_FLUSH_URL = 'digital-nature/flush-cache';
    const MODEL_NOTES_URL = 'digital-nature/notes';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu'], 20);
    }

    /**
     * Adds the menu items
     *
     * @return void
     */
    public function add_admin_menu(): void
    {
        add_menu_page(
            'Digital Nature',
            'Digital Nature',
            DigitalNatureMenuCapability::get_capability_name(),
            'digital-nature',
            [ $this, 'digital_nature_view' ],
	        UtilitiesConfig::get_plugin_url() . 'assets/admin/img/digital-nature-white-sml.png',
            2
        );

        add_submenu_page(
            '',
            'Model Notes',
            'Model Notes',
            'administrator',
            self::MODEL_NOTES_URL,
            [$this, 'digital_nature_model_notes_view']
        );

        // CACHE FLUSHING PAGES
        add_submenu_page(
            '',
            'Cache Flush',
            'Cache Flush',
            'edit_pages',
            self::CACHE_FLUSH_URL,
            [$this, 'digital_nature_flush_cache']
        );

        $role = get_role('administrator');
        $role->add_cap(DigitalNatureMenuCapability::get_capability_name(), true);
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
            trailingslashit(UtilitiesConfig::get_plugin_dir() . '/templates')
        );
    }

    /**
     * @return void
     */
    public function digital_nature_flush_cache()
    {
        $key = $_GET['key'] ?? null;

        if (!$key) {
            MessageHelper::error_and_exit('You must submit a cache key to flush. Go back and try again');
        }

        delete_transient($key);

        // send them back where they came from
        wp_safe_redirect(wp_get_referer());
        exit;
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
            trailingslashit(UtilitiesConfig::get_plugin_dir() . '/templates')
        );
    }
}