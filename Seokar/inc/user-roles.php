<?php
/**
 * مدیریت نقش‌های کاربری در قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

class Seokar_User_Roles {
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'add_custom_roles'));
        add_action('init', array($this, 'modify_existing_roles'));
        register_deactivation_hook(__FILE__, array($this, 'remove_custom_roles'));
    }

    // ۱. افزودن نقش‌های سفارشی
    public function add_custom_roles() {
        add_role(
            'seo_manager',
            __('مدیر سئو', 'seokar'),
            array(
                'read'                  => true,
                'edit_posts'            => true,
                'delete_posts'          => false,
                'manage_categories'     => true,
                'moderate_comments'     => true,
                'upload_files'          => true,
                'edit_theme_options'    => false,
                'manage_options'        => false,
            )
        );

        add_role(
            'support_agent',
            __('پشتیبان سایت', 'seokar'),
            array(
                'read'                  => true,
                'edit_posts'            => false,
                'delete_posts'          => false,
                'manage_categories'     => false,
                'moderate_comments'     => true,
                'upload_files'          => true,
                'edit_theme_options'    => false,
                'manage_options'        => false,
            )
        );
    }

    // ۲. افزودن قابلیت‌های جدید به نقش‌های پیش‌فرض وردپرس
    public function modify_existing_roles() {
        $editor = get_role('editor');
        if ($editor) {
            $editor->add_cap('manage_categories');
            $editor->add_cap('moderate_comments');
            $editor->add_cap('upload_files');
        }

        $author = get_role('author');
        if ($author) {
            $author->add_cap('upload_files');
        }
    }

    // ۳. حذف نقش‌های سفارشی هنگام غیرفعال کردن قالب
    public function remove_custom_roles() {
        remove_role('seo_manager');
        remove_role('support_agent');
    }
}

// مقداردهی اولیه کلاس
Seokar_User_Roles::get_instance();
