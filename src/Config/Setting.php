<?php

namespace DigitalNature\Utilities\Config;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Setting
{
    /**
     * @return string
     */
    public abstract function get_setting_page_slug(): string;

    /**
     * @return string
     */
    public abstract function get_setting_page_title(): string;

    /**
     * @return string
     */
    public abstract function get_option_name(): string;

    /**
     * @return string
     */
    public abstract function get_option_group(): string;

    /**
     * @return string
     */
    public abstract function get_messages_slug(): string;

    /**
     * @return SettingField[]
     */
    protected abstract function get_fields(): array;

    /**
     * @return string
     */
    protected abstract function get_section_id(): string;

    /**
     * @return string
     */
    protected abstract function get_section_title(): string;

    /**
     * @return string
     */
    public abstract function get_section_content(): string;

    /**
     * Returns the option value
     *
     * @return false|mixed|null
     */
    public function get_option()
    {
        $optionName = $this->get_option_name();
        return get_option($optionName);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        // register this setting
        register_setting(
            $this->get_option_group(),
            $this->get_option_name(),
            [$this, 'options_validate']
        );

        // add the section
        add_settings_section(
            $this->get_section_id(),
            $this->get_section_title(),
            [$this, 'get_section_content'],
            $this->get_option_group(),
        );

        // populate the section with the fields
        foreach ($this->get_fields() as $field) {
            add_settings_field(
                $field->get_field_name(),
                $field->get_field_title(),
                [$field, 'get_field_html'],
                $this->get_option_group(),
                $this->get_section_id()
            );
        }
    }

    /**
     * @param array $submitted
     * @return array
     */
    public function options_validate(array $submitted): array
    {
        foreach ($this->get_fields() as $field) {
            if (!$field::is_valid($submitted)) {
                $submitted[$field::get_field_name()] = '';
                add_settings_error( $this->get_messages_slug(), $this->get_messages_slug(), __( $field::get_field_title() . ' is not valid' , $this->get_setting_page_slug() ), 'error' );
            }
        }

        return $submitted;
    }
}
