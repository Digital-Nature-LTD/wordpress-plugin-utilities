<?php
/**
 * dn-utilities
 *
 * @package       DIGITAL_NATURE_UTILITIES
 * @author        Digital Nature
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Digital Nature - Utilities
 * Plugin URI:    https://www.digital-nature.co.uk
 * Description:   Provides utilities for use with WordPress, plus the Digital Nature menu item and associated roles
 * Version:       1.0.0
 * Author:        Digital Nature
 * Author URI:    https://www.digital-nature.co.uk
 * Text Domain:   dn-utilities
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with dn-utilities. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

use DigitalNature\Utilities\Bootstrap;
use DigitalNature\Utilities\Config\PluginConfig;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Bring in the autoloader
 */
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// bootstrap the plugin once the rest have loaded
add_action('plugins_loaded', 'bootstrap_plugin_dn_utilities');

function bootstrap_plugin_dn_utilities()
{
    PluginConfig::configure(__FILE__, '1.0.0');
    Bootstrap::instance();

    do_action('digital_nature_utilities_plugin_loaded');
}

