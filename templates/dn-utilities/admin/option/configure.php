<?php
/** @var Setting $setting */

use DigitalNature\Utilities\Config\Setting;

?>

<div class="digital-nature-admin-wrap">
    <div class="digital-nature-admin-wrap-title">
        <h2><?= $setting->get_setting_page_title(); ?></h2>
    </div>

    <div class="digital-nature-admin-wrap-content">
        <div class="digital-nature-admin-wrap-panel-title">
            <?= $setting->get_section_content(); ?>
        </div>
        <div class="digital-nature-admin-wrap-panel-body">
            <?php
            // show error/update messages
            settings_errors($setting->get_messages_slug());
            ?>

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
        </div>
    </div>
</div>