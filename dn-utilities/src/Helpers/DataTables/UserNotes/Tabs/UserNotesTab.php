<?php

namespace DigitalNature\Utilities\Helpers\DataTables\UserNotes\Tabs;

use DigitalNature\Utilities\Helpers\DataTables\UserNotes\UserNotesDataTableHelper;
use DigitalNature\Utilities\Helpers\DataTableTabHelper;
use DigitalNature\WordPressUtilities\Helpers\MessageHelper;
use DigitalNature\WordPressUtilities\Models\UserNote;
use WP_Post;
use WP_Query;
use WP_User;

class UserNotesTab extends DataTableTabHelper
{
    /**
     * @var WP_User|null
     */
    private ?WP_User $user = null;

    /**
     *
     */
    public function __construct()
    {
        $userId = $_GET['user'] ?? null;

        if (!$userId) {
            MessageHelper::error_and_exit('You must submit a user to view notes. Go back and try again');
        }

        $user = get_user_by('ID', $userId);

        if (!$user) {
            MessageHelper::error_and_exit("Could not find user with ID $userId");
        }

        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function is_searchable(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function is_paginated(): bool
    {
        return true;
    }

    public function get_label(): string
    {
        return 'Notes';
    }

    public function get_slug(): string
    {
        return 'user-notes';
    }

    /**
     * @return array
     */
    public function get_data(): array
    {
        if (empty($this->user)) {
            return [];
        }

        if (UserNotesDataTableHelper::is_searching_by_id()) {
            $data = $this->get_notes_by_id();
        } else {
            $data = $this->get_notes();
        }

        return $this->format_data_for_table($data);
    }

    /**
     * @return int
     */
    public function get_result_count(): int
    {
        // if searching by ID then it's either 1 or 0, we don't need to count posts
        if (UserNotesDataTableHelper::is_searching_by_id()) {
            return count($this->get_notes_by_id());
        }

        $query = $this->get_query();

        return $query->found_posts;
    }

    /**
     * Gets records by ID
     *
     * @return array
     */
    protected function get_notes_by_id(): array
    {
        /** @var UserNote $subscription */
        $note = UserNote::from_id(UserNotesDataTableHelper::get_active_search_term());

        if (!$note) {
            return [];
        }

        if ($note->user_id !== $this->user->ID) {
            // it's from another user, don't return it
            return [];
        }

        return [
            $note->id => $note
        ];
    }

    /**
     * @return array
     */
    protected function get_notes(): array
    {
        $query = $this->get_query();

        return $query->get_posts();
    }

    /**
     * @return WP_Query
     */
    protected function get_query(): WP_Query
    {
        return new WP_Query([
            'posts_per_page' => UserNotesDataTableHelper::get_active_page_size(),
            'offset' => UserNotesDataTableHelper::get_active_page_offset(),
            'page' => UserNotesDataTableHelper::get_active_page_no(),
            'post_type'     => UserNote::get_post_type(),
            'post_status'   => 'publish',
            'orderby' => [
                'ID' => 'DESC',
                'meta_value_num' => 'DESC',
            ],
            'meta_key' => UserNote::METADATA_KEY_NOTE_WRITTEN_ON,
            'meta_query' => $this->get_meta_query(),
        ]);
    }

    /**
     * @return array
     */
    protected function get_meta_query(): array
    {
        if (UserNotesDataTableHelper::is_searching()) {
            $searchTerm = UserNotesDataTableHelper::get_active_search_term();

            return [
                'relation' => 'AND',
                [
                    'key'   => UserNote::METADATA_KEY_NOTE,
                    'value' => $searchTerm,
                    'compare' => 'LIKE'
                ],
                [
                    'key'   => UserNote::METADATA_KEY_NOTE_USER_ID,
                    'value' => $this->user->ID,
                    'compare' => '='
                ],
            ];
        }

        return [
            [
                'key'   => UserNote::METADATA_KEY_NOTE_USER_ID,
                'value' => $this->user->ID,
                'compare' => '='
            ],
        ];
    }

    /**
     * Formats the records for use in a data table
     * @param array $records
     * @return array
     */
    protected function format_data_for_table(array $records): array
    {
        $formattedRecords = [];

        foreach ($records as $note) {
            if ($note instanceof WP_Post) {
                $note = UserNote::from_id($note->ID);
            }

            $date = $note->get_created_datetime();
            $user = $note->get_user();

            $formattedRecords[] = [
                'Date' => ($date ? $date->format('d/m/Y H:i:s') : 'unknown'),
                'Note' => $note->get_note(),
                'Author' => $user->display_name
            ];
        }

        return $formattedRecords;
    }
}