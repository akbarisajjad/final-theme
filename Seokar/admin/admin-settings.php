<?php
/**
 * مدیریت تنظیمات قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

class Seokar_Admin_Settings {
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
    }

    // ۱. ثبت تنظیمات قالب
    public function register_settings() {
        register_setting('seokar_theme_settings', 'seokar_logo');
        register_setting('seokar_theme_settings', 'seokar_primary_color');
        register_setting('seokar_theme_settings', 'seokar_enable_dark_mode');

        add_settings_section(
            'seokar_general_section',
            __('تنظیمات عمومی قالب', 'seokar'),
            '__return_false',
            'seokar_theme_settings'
        );

        add_settings_field(
            'seokar_logo',
            __('لوگوی سایت', 'seokar'),
            array($this, 'logo_field_callback'),
            'seokar_theme_settings',
            'seokar_general_section'
        );

        add_settings_field(
            'seokar_primary_color',
            __('رنگ اصلی قالب', 'seokar'),
            array($this, 'color_field_callback'),
            'seokar_theme_settings',
            'seokar_general_section'
        );

        add_settings_field(
            'seokar_enable_dark_mode',
            __('فعال‌سازی حالت تاریک', 'seokar'),
            array($this, 'dark_mode_callback'),
            'seokar_theme_settings',
            'seokar_general_section'
        );
    }

    // ۲. فیلدهای تنظیمات
    public function logo_field_callback() {
        $value = get_option('seokar_logo', '');
        echo '<input type="text" name="seokar_logo" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('آدرس لوگوی سایت را وارد کنید.', 'seokar') . '</p>';
    }

    public function color_field_callback() {
        $value = get_option('seokar_primary_color', '#0073e6');
        echo '<input type="color" name="seokar_primary_color" value="' . esc_attr($value) . '">';
    }

    public function dark_mode_callback() {
        $value = get_option('seokar_enable_dark_mode', false);
        echo '<input type="checkbox" name="seokar_enable_dark_mode" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر این گزینه فعال باشد، حالت تاریک در سایت فعال می‌شود.', 'seokar') . '</p>';
    }
}

// مقداردهی اولیه کلاس
Seokar_Admin_Settings::get_instance();
