<?php
/** @var Setting $setting */

use DigitalNature\Utilities\Config\PluginConfig;
use DigitalNature\Utilities\Config\Setting;

?>

<div class="digital-nature-admin-wrap-global digital-nature-admin-wrap">
    <div class="digital-nature-hero digital-nature-grid-overlay-container digital-nature-theme-green">
        <a href="https://www.digital-nature.co.uk/" class="digital-nature-logo" target="_blank">
            <img height="34px" src="<?= PluginConfig::get_plugin_url(); ?>/assets/common/img/brand/digital-nature-logo-primary.svg" alt="The Digital Nature logo" />
        </a>
        <div class="front">
            <div class="left">
                <h2><?= $setting->get_setting_page_title(); ?></h2>
            </div>
        </div>
        <div class="back">
            <div class="right">
                <img src="<?= PluginConfig::get_plugin_url(); ?>/assets/common/img/coast.png" alt="Overhead view of a coastline including trees, shrubs, and grass." />
                <digital-nature-grid-overlay class="s-6 green">
                    <digital-nature-grid-overlay-cell class="c-1 r-1 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-1 r-2 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-1 r-3 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-1 r-4 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-1 r-5 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-2 r-3 o-5"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-2 r-6 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-3 r-4 o-5"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-5 r-1 o-4"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-6 r-1 o-10"></digital-nature-grid-overlay-cell>
                    <digital-nature-grid-overlay-cell class="c-6 r-6 o-10"></digital-nature-grid-overlay-cell>
                </digital-nature-grid-overlay>
            </div>
        </div>
    </div>

    <div class="digital-nature-admin-wrap-content">
        <?php do_action("{$setting->get_option_name()}_configuration_before_panel_title"); ?>
        <div class="digital-nature-admin-wrap-panel-title">
            <?= $setting->get_section_content(); ?>
        </div>
        <?php do_action("{$setting->get_option_name()}_configuration_after_panel_title"); ?>

        <?php do_action("{$setting->get_option_name()}_configuration_before_panel_body"); ?>
        <div class="digital-nature-admin-wrap-panel-body">
            <?php do_action("{$setting->get_option_name()}_configuration_panel_body_before_errors"); ?>
            <?php
            if (!empty($_GET['settings-updated'])) {
                echo '<div class="notice notice-success is-dismissible"><p><strong>Settings saved</strong></p></div>';
            }

            // show error/update messages
            settings_errors($setting->get_messages_slug());
            ?>
            <?php do_action("{$setting->get_option_name()}_configuration_panel_body_after_errors"); ?>

            <?php do_action("{$setting->get_option_name()}_configuration_panel_body_before_form"); ?>
            <form action="options.php" method="post">
                <?php
                // output security fields
                settings_fields($setting->get_option_group());
                // output setting sections and their fields
                do_settings_sections($setting->get_option_group());
                // output save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
            <?php do_action("{$setting->get_option_name()}_configuration_panel_body_after_form"); ?>
        </div>

        <?php do_action("{$setting->get_option_name()}_configuration_after_panel_body"); ?>
    </div>
</div>