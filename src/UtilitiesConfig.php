<?php

namespace DigitalNature\Utilities;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class UtilitiesConfig
{
	/**
	 * @return string
	 */
	public static function get_plugin_name(): string
	{
		return DN_UTILITIES_NAME;
	}

	/**
	 * @return string
	 */
	public static function get_plugin_url(): string
	{
		return DN_UTILITIES_PLUGIN_URL;
	}

	/**
	 * @return string
	 */
	public static function get_plugin_dir(): string
	{
		return DN_UTILITIES_PLUGIN_DIR;
	}
}