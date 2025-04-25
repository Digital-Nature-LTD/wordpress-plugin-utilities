<?php
/** @var Setting $setting */

use DigitalNature\Utilities\Config\Setting;

?>

<div class="digital-nature-admin-wrap">
    <div class="digital-nature-admin-wrap-title">
        <h2><?= $setting->get_setting_page_title(); ?></h2>
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
            if (!empty( $_GET['settings-updated'] )) {
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