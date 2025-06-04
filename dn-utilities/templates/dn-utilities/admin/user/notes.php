<?php
/** @var WP_User $user */

use DigitalNature\Utilities\Helpers\DataTables\UserNotes\UserNotesDataTableHelper;

$helper = new UserNotesDataTableHelper();

?>

<div class="wrap">
    <h1>
        User notes
        <a class="button" href="<?= $helper::get_cache_flush_url(); ?>">Refresh data</a>
    </h1>

    <h2>
        Notes for user #<?= $user->ID; ?>
    </h2>

    <div id="user-notes-view">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?= $helper::render_tab_intro(); ?>
        <?= $helper::render_tabs(); ?>

        <div class="tab-content">
            <?= $helper::render_search(); ?>
            <?= $helper::render_table(); ?>
            <?= $helper::render_pagination(); ?>
        </div>
    </div>
</div>