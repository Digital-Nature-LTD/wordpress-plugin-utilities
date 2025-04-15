<?php

namespace DigitalNature\Utilities\Config;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

abstract class SettingField
{
    public Setting $setting;

    /**
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @return string
     */
    public abstract static function get_field_title(): string;

    /**
     * @return string
     */
    public abstract static function get_field_name(): string;

    /**
     * @return string
     */
    public abstract static function get_field_id(): string;

    /**
     * @param array $submitted
     * @return bool
     */
    public abstract static function is_valid(array $submitted): bool;

    /**
     * @return void
     */
    public function get_field_html(): void
    {
        $optionName = $this->setting->get_option_name();
        $options = $this->setting->get_option();

        $fieldId = static::get_field_id();
        $fieldName = static::get_field_name();
        $currentValue = esc_attr($options[$fieldName] ?? '');

        echo "<input id='$fieldId' name='{$optionName}[{$fieldName}]' type='text' value='$currentValue' />";
    }
}
