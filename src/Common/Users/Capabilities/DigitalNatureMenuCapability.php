<?php

namespace DigitalNature\Utilities\Common\Users\Capabilities;

use DigitalNature\WordPressUtilities\Common\Users\Capabilities\BaseCapability;

class DigitalNatureMenuCapability extends BaseCapability
{
	/**
	 * @return string
	 */
	public static function get_capability_name(): string
	{
		return 'digital_nature_menu';
	}
}