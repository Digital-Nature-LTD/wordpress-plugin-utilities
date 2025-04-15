<?php
/** @var Setting $setting */

use DigitalNature\Utilities\Config\Setting;

?>

<h2><?= $setting->get_setting_page_title(); ?></h2>
<form action="options.php" method="post">

    <?php
    // show error/update messages
    settings_errors($setting->get_messages_slug());

    // output security fields
    settings_fields($setting->get_option_group());
    // output setting sections and their fields
    do_settings_sections($setting->get_option_group());
    // output save settings button
    submit_button( 'Save Settings' );
    ?>
</form>