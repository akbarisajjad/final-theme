<?php
/**
 * مدیریت تنظیمات پیشرفته قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit; // خروج در صورت دسترسی مستقیم به فایل
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
        // افزودن هوک‌ها
        add_action('customize_register', array($this, 'register_customizer_settings'));
        add_action('admin_menu', array($this, 'add_theme_options_page'));
        add_action('admin_init', array($this, 'register_theme_settings'));
        add_action('wp_head', array($this, 'track_post_views'));
        add_action('save_post', array($this, 'generate_sitemap'));
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
        // تنظیمات اصلی
        register_setting('seokar_theme_settings', 'seokar_enable_dark_mode');
        register_setting('seokar_theme_settings', 'seokar_google_analytics');
        register_setting('seokar_theme_settings', 'seokar_ads_banner');
        register_setting('seokar_theme_settings', 'seokar_lazyload');
        register_setting('seokar_theme_settings', 'seokar_disable_emoji');
        register_setting('seokar_theme_settings', 'seokar_disable_embeds');
        register_setting('seokar_theme_settings', 'seokar_enable_amp');
        register_setting('seokar_theme_settings', 'seokar_enable_sitemap');
        register_setting('seokar_theme_settings', 'seokar_disable_rss');
        register_setting('seokar_theme_settings', 'seokar_ad_header');
        register_setting('seokar_theme_settings', 'seokar_ad_footer');

        // سکشن تنظیمات کلی
        add_settings_section(
            'seokar_theme_main_section',
            __('تنظیمات کلی قالب', 'seokar'),
            '__return_false',
            'seokar_theme_options'
        );

        // فیلدهای تنظیمات
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

        add_settings_field(
            'seokar_lazyload',
            __('فعال‌سازی بارگذاری تنبل تصاویر', 'seokar'),
            array($this, 'lazyload_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_enable_amp',
            __('فعال‌سازی AMP', 'seokar'),
            array($this, 'enable_amp_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_enable_sitemap',
            __('فعال‌سازی نقشه سایت XML', 'seokar'),
            array($this, 'enable_sitemap_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_disable_rss',
            __('غیرفعال‌سازی فید RSS', 'seokar'),
            array($this, 'disable_rss_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_ad_header',
            __('تبلیغ در هدر', 'seokar'),
            array($this, 'ad_header_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );

        add_settings_field(
            'seokar_ad_footer',
            __('تبلیغ در فوتر', 'seokar'),
            array($this, 'ad_footer_callback'),
            'seokar_theme_options',
            'seokar_theme_main_section'
        );
    }

    // ۵. فیلدهای تنظیمات
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

    public function lazyload_callback() {
        $value = get_option('seokar_lazyload', false);
        echo '<input type="checkbox" name="seokar_lazyload" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، تصاویر فقط هنگام مشاهده توسط کاربر بارگذاری می‌شوند.', 'seokar') . '</p>';
    }

    public function enable_amp_callback() {
        $value = get_option('seokar_enable_amp', false);
        echo '<input type="checkbox" name="seokar_enable_amp" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، نسخه AMP صفحات ایجاد خواهد شد.', 'seokar') . '</p>';
    }

    public function enable_sitemap_callback() {
        $value = get_option('seokar_enable_sitemap', false);
        echo '<input type="checkbox" name="seokar_enable_sitemap" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، نقشه سایت XML به‌صورت خودکار ایجاد می‌شود.', 'seokar') . '</p>';
    }

    public function disable_rss_callback() {
        $value = get_option('seokar_disable_rss', false);
        echo '<input type="checkbox" name="seokar_disable_rss" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('با فعال کردن این گزینه، فید RSS سایت غیرفعال می‌شود.', 'seokar') . '</p>';
    }

    public function ad_header_callback() {
        $value = get_option('seokar_ad_header', '');
        echo '<input type="text" name="seokar_ad_header" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('لینک تصویر تبلیغاتی برای نمایش در هدر.', 'seokar') . '</p>';
    }

    public function ad_footer_callback() {
        $value = get_option('seokar_ad_footer', '');
        echo '<input type="text" name="seokar_ad_footer" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('لینک تصویر تبلیغاتی برای نمایش در فوتر.', 'seokar') . '</p>';
    }

    // ۶. مدیریت بازدیدهای پست
    public function track_post_views() {
        if (is_single()) {
            $postID = get_the_ID();
            $count = get_post_meta($postID, 'seokar_post_views', true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, 'seokar_post_views');
                add_post_meta($postID, 'seokar_post_views', '0');
            } else {
                $count++;
                update_post_meta($postID, 'seokar_post_views', $count);
            }
        }
    }

    // ۷. ایجاد نقشه سایت XML
    public function generate_sitemap() {
        if (!get_option('seokar_enable_sitemap')) {
            return;
        }

        $posts = get_posts(array('numberposts' => -1, 'post_type' => 'post', 'post_status' => 'publish'));
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($posts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . get_permalink($post->ID) . '</loc>';
            $xml .= '<lastmod>' . get_the_modified_time('Y-m-d', $post->ID) . '</lastmod>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';
        file_put_contents(ABSPATH . 'sitemap.xml', $xml);
    }
}

// مقداردهی اولیه کلاس
Seokar_Theme_Options::get_instance();
