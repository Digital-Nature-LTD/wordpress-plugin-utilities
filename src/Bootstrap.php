<?php

namespace DigitalNature\Utilities;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists('Bootstrap') ) :

    /**
     * Main Bootstrap Class.
     *
     * @package		DN_UTILITIES
     * @since		1.0.0
     * @author		Gareth Midwood
     */
    final class Bootstrap {

        /**
         * The real instance
         *
         * @access	private
         * @since	1.0.0
         * @var		object|Bootstrap
         */
        private static $instance;

        /**
         * Throw error on object clone.
         *
         * Cloning instances of the class is forbidden.
         *
         * @access	public
         * @since	1.0.0
         * @return	void
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'dn-utilities' ), '1.0.0' );
        }

        /**
         * Disable unserializing of the class.
         *
         * @access	public
         * @since	1.0.0
         * @return	void
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'dn-utilities' ), '1.0.0' );
        }

        /**
         * Main Bootstrap Instance.
         *
         * Insures that only one instance of Bootstrap exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @access		public
         * @return		object|Bootstrap	The one true Bootstrap
         * @since		1.0.0
         * @static
         */
        public static function instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Bootstrap) ) {
                self::$instance					= new Bootstrap;
                self::$instance->includes();

                /**
                 * Fire a custom action to allow dependencies
                 * after the successful plugin setup
                 */
                do_action( 'DN_UTILITIES/plugin_loaded' );
            }

            return self::$instance;
        }

        /**
         * Include required files.
         *
         * @access  private
         * @since   1.0.0
         * @return  void
         */
        private function includes() {
            // plugin status changes
            new \DigitalNature\Utilities\Wp\Activation();

            // admin
            new \DigitalNature\Utilities\Admin\Includes();
        }
    }

endif; // End if class_exists check.