<?php

/**
 * This adds the _nonce field to the pages where rest calls are made
 */

namespace DigitalNature\Utilities\Wp\Api;

class WPRest
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'add_nonce_to_rest_pages'], 10);
    }

    /**
     * Adds the nonce to the specified pages
     */
    public function add_nonce_to_rest_pages()
    {
        // if you have rules over which pages the nonce should be added to
        // then put the logic here, just return from this function where it
        // should NOT be added.


        // we'll put the field in the footer
        add_action('admin_footer', [$this, 'add_nonce_input_field']);
    }

    public function add_nonce_input_field() {
        $_wpnonce = wp_create_nonce( 'wp_rest' );
        echo "<input type='hidden' name='_wpnonce' value='$_wpnonce' />";
    }
}