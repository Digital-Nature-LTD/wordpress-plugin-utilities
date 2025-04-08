<?php
/**
 * dn-utilities
 *
 * @package       DN_UTILITIES
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

// Exit if accessed directly.
use DigitalNature\Utilities\Bootstrap;

if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define('DN_UTILITIES_NAME',			'dn-utilities');

// Plugin visible name
define('DN_UTILITIES_FRIENDLY_NAME', 'Digital Nature - Utilities');

// Plugin version
define('DN_UTILITIES_VERSION',		'1.0.0');

// Plugin Root File
define('DN_UTILITIES_PLUGIN_FILE',	__FILE__);

// Plugin base
define('DN_UTILITIES_PLUGIN_BASE',	plugin_basename(DN_UTILITIES_PLUGIN_FILE));

// Plugin Folder Path
define('DN_UTILITIES_PLUGIN_DIR',	plugin_dir_path(DN_UTILITIES_PLUGIN_FILE));

// Plugin Folder URL
define('DN_UTILITIES_PLUGIN_URL',	plugin_dir_url(DN_UTILITIES_PLUGIN_FILE));

/**
 * Bring in the autoloader
 */
require_once DN_UTILITIES_PLUGIN_DIR . 'vendor/autoload.php';

/**
 * Bring in the bootstrap class
 *
 * @return  Bootstrap|object
 * @since   1.0.0
 * @author  Gareth Midwood
 */
function DN_UTILITIES() {
	return Bootstrap::instance();
}

DN_UTILITIES();
