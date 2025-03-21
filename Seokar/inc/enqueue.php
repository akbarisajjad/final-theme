<?php
/**
 * Enqueue Scripts & Styles
 *
 * @package Seokar
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('seokar_enqueue_scripts')) {
    function seokar_enqueue_scripts() {
        // مسیرهای اصلی قالب
        $theme_version = wp_get_theme()->get('Version');
        $theme_dir = get_template_directory_uri();

        // ** بارگذاری استایل‌ها **
        wp_enqueue_style('seokar-style', $theme_dir . '/assets/css/style.css', array(), $theme_version, 'all');
        wp_enqueue_style('seokar-custom', $theme_dir . '/assets/css/custom.css', array(), $theme_version, 'all');
        wp_enqueue_style('seokar-dark-mode', $theme_dir . '/assets/css/dark-mode.css', array(), $theme_version, 'all');
        wp_enqueue_style('seokar-accessibility', $theme_dir . '/assets/css/accessibility.css', array(), $theme_version, 'all');

        // بارگذاری استایل RTL در صورت نیاز
        if (is_rtl()) {
            wp_enqueue_style('seokar-rtl', $theme_dir . '/assets/css/rtl.css', array(), $theme_version, 'all');
        }

        // ** بارگذاری اسکریپت‌ها **
        wp_enqueue_script('jquery'); // بارگذاری jQuery وردپرس

        wp_enqueue_script('seokar-scripts', $theme_dir . '/assets/js/scripts.js', array('jquery'), $theme_version, true);
        wp_enqueue_script('seokar-custom', $theme_dir . '/assets/js/custom.js', array('jquery'), $theme_version, true);
        wp_enqueue_script('seokar-ajax', $theme_dir . '/assets/js/ajax-handlers.js', array('jquery'), $theme_version, true);
        wp_enqueue_script('seokar-dark-mode', $theme_dir . '/assets/js/dark-mode-switcher.js', array(), $theme_version, true);

        // ** انتقال داده‌های AJAX به جاوا اسکریپت **
        wp_localize_script('seokar-ajax', 'seokar_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('seokar_ajax_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_scripts');

/**
 * بارگذاری استایل‌های پنل مدیریت
 */
if (!function_exists('seokar_admin_styles')) {
    function seokar_admin_styles() {
        wp_enqueue_style('seokar-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css', array(), wp_get_theme()->get('Version'), 'all');
        wp_enqueue_script('seokar-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', array('jquery'), wp_get_theme()->get('Version'), true);
    }
}
add_action('admin_enqueue_scripts', 'seokar_admin_styles');
?>
