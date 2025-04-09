<?php

namespace DigitalNature\Utilities\Common\Users\Roles;

use DigitalNature\Utilities\Common\Users\Capabilities\DigitalNatureMenuCapability;
use DigitalNature\WordPressUtilities\Common\Users\Roles\BaseRole;

class DigitalNatureAdminRole extends BaseRole
{
	/**
	 * @return string
	 */
	public static function get_role_slug(): string
	{
		return 'digital_nature_admin';
	}

	/**
	 * @return string
	 */
	public static function get_role_name(): string
	{
		return 'Digital Nature Admin';
	}

	/**
	 * @return string[]
	 */
	public static function get_capabilities(): array
	{
		return [
			DigitalNatureMenuCapability::get_capability_name()
		];
	}
}