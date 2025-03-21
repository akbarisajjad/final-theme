<?php
/**
 * مدیریت تنظیمات پیشرفته قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

class Seokar_Theme_Options {
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('customize_register', array($this, 'register_customizer_settings'));
        add_action('admin_menu', array($this, 'add_theme_options_page'));
        add_action('admin_init', array($this, 'register_theme_settings'));
    }

    // ۱. افزودن تنظیمات به سفارشی‌ساز (Customizer)
    public function register_customizer_settings($wp_customize) {
        // سکشن تنظیمات عمومی
        $wp_customize->add_section('seokar_general_settings', array(
            'title'    => __('تنظیمات عمومی قالب', 'seokar'),
            'priority' => 30,
        ));

        // گزینه آپلود لوگو
        $wp_customize->add_setting('seokar_logo', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'seokar_logo',
            array(
                'label'    => __('لوگوی سایت', 'seokar'),
                'section'  => 'seokar_general_settings',
                'settings' => 'seokar_logo',
            )
        ));

        // تنظیمات رنگ‌بندی
        $wp_customize->add_setting('seokar_primary_color', array(
            'default'           => '#0073e6',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'seokar_primary_color',
            array(
                'label'    => __('رنگ اصلی قالب', 'seokar'),
                'section'  => 'seokar_general_settings',
                'settings' => 'seokar_primary_color',
            )
        ));

        // تنظیمات فونت
        $wp_customize->add_setting('seokar_font_family', array(
            'default'           => 'Vazir',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('seokar_font_family', array(
            'label'    => __('فونت اصلی سایت', 'seokar'),
            'section'  => 'seokar_general_settings',
            'type'     => 'select',
            'choices'  => array(
                'Vazir'    => 'وزیر',
                'IRANSans' => 'ایران سنس',
                'Roboto'   => 'Roboto',
            ),
        ));

        // تنظیمات شبکه‌های اجتماعی
        $wp_customize->add_setting('seokar_instagram', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('seokar_instagram', array(
            'label'   => __('لینک اینستاگرام', 'seokar'),
            'section' => 'seokar_general_settings',
            'type'    => 'url',
        ));
    }

    // ۲. افزودن صفحه تنظیمات قالب در پیشخوان وردپرس
    public function add_theme_options_page() {
        add_theme_page(
            __('تنظیمات Seokar', 'seokar'),
            __('تنظیمات Seokar', 'seokar'),
            'manage_options',
            'seokar-theme-options',
            array($this, 'render_theme_options_page')
        );
    }

    // ۳. نمایش محتوای صفحه تنظیمات قالب
    public function render_theme_options_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('تنظیمات قالب Seokar', 'seokar'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('seokar_theme_settings');
                do_settings_sections('seokar_theme_options');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // ۴. ثبت گزینه‌های قالب
    public function register_theme_settings() {
        register_setting('seokar_theme_settings', 'seokar_enable_dark_mode');
        register_setting('seokar_theme_settings', 'seokar_google_analytics');
        register_setting('seokar_theme_settings', 'seokar_ads_banner');

        add_settings_section(
            'seokar_theme_main_section',
            __('تنظیمات کلی قالب', 'seokar'),
            '__return_false',
            'seokar_theme_options'
        );

        add_settings_field(
            'seokar_enable_dark_mode',
            __('فعال‌سازی حالت تاریک', 'seokar'),
            array($this, 'dark_mode_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_google_analytics',
            __('کد گوگل آنالیتیکس', 'seokar'),
            array($this, 'google_analytics_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_ads_banner',
            __('تصویر تبلیغاتی', 'seokar'),
            array($this, 'ads_banner_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );
    }

    // ۵. فیلدها
    public function dark_mode_callback() {
        $value = get_option('seokar_enable_dark_mode', false);
        echo '<input type="checkbox" name="seokar_enable_dark_mode" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، حالت تاریک اعمال خواهد شد.', 'seokar') . '</p>';
    }

    public function google_analytics_callback() {
        $value = get_option('seokar_google_analytics', '');
        echo '<textarea name="seokar_google_analytics" class="large-text">' . esc_textarea($value) . '</textarea>';
        echo '<p class="description">' . __('کد رهگیری گوگل آنالیتیکس را اینجا وارد کنید.', 'seokar') . '</p>';
    }

    public function ads_banner_callback() {
        $value = get_option('seokar_ads_banner', '');
        echo '<input type="text" name="seokar_ads_banner" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('آدرس تصویر تبلیغاتی را وارد کنید.', 'seokar') . '</p>';
    }
}

// مقداردهی اولیه کلاس
Seokar_Theme_Options::get_instance();
