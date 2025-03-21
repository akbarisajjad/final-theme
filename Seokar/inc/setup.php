<?php
/**
 * Theme Setup File
 *
 * @package Seokar
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('seokar_theme_setup')) {
    function seokar_theme_setup() {
        // پشتیبانی از عنوان پویا
        add_theme_support('title-tag');

        // پشتیبانی از تصاویر شاخص
        add_theme_support('post-thumbnails');

        // ثبت اندازه‌های سفارشی برای تصاویر شاخص
        add_image_size('seokar-thumbnail', 800, 600, true); // 800x600 کراپ شده
        add_image_size('seokar-banner', 1600, 600, true); // 1600x600 برای بنرها

        // پشتیبانی از HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ));

        // پشتیبانی از ناوبری وردپرس
        register_nav_menus(array(
            'primary' => __('منوی اصلی', 'seokar'),
            'footer'  => __('منوی فوتر', 'seokar'),
        ));

        // پشتیبانی از لوگوی سفارشی
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 300,
            'flex-height' => true,
            'flex-width'  => true,
        ));

        // پشتیبانی از رنگ پس‌زمینه سفارشی
        add_theme_support('custom-background', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ));

        // پشتیبانی از ابزارک‌های وردپرس
        add_theme_support('widgets');

        // تنظیم عرض پیش‌فرض محتوا
        if (!isset($GLOBALS['content_width'])) {
            $GLOBALS['content_width'] = 1200;
        }
    }
}
add_action('after_setup_theme', 'seokar_theme_setup');
?>
