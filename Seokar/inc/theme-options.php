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
register_setting('seokar_theme_settings', 'seokar_lazyload');
add_settings_field(
    'seokar_lazyload',
    __('فعال‌سازی بارگذاری تنبل تصاویر', 'seokar'),
    function() {
        $value = get_option('seokar_lazyload', false);
        echo '<input type="checkbox" name="seokar_lazyload" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، تصاویر فقط هنگام مشاهده توسط کاربر بارگذاری می‌شوند.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);
register_setting('seokar_theme_settings', 'seokar_disable_emoji');
register_setting('seokar_theme_settings', 'seokar_disable_embeds');

add_settings_field(
    'seokar_disable_emoji',
    __('حذف ایموجی‌های وردپرس', 'seokar'),
    function() {
        $value = get_option('seokar_disable_emoji', false);
        echo '<input type="checkbox" name="seokar_disable_emoji" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، ایموجی‌های پیش‌فرض وردپرس غیرفعال خواهند شد.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

add_settings_field(
    'seokar_disable_embeds',
    __('غیرفعال‌سازی Embeds وردپرس', 'seokar'),
    function() {
        $value = get_option('seokar_disable_embeds', false);
        echo '<input type="checkbox" name="seokar_disable_embeds" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، قابلیت Embeds که باعث بارگذاری اسکریپت‌های اضافی می‌شود، غیرفعال خواهد شد.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

if (class_exists('WooCommerce')) {
    register_setting('seokar_theme_settings', 'seokar_catalog_mode');
    register_setting('seokar_theme_settings', 'seokar_hide_product_reviews');

    add_settings_field(
        'seokar_catalog_mode',
        __('فعال‌سازی حالت کاتالوگ', 'seokar'),
        function() {
            $value = get_option('seokar_catalog_mode', false);
            echo '<input type="checkbox" name="seokar_catalog_mode" value="1" ' . checked(1, $value, false) . '>';
            echo '<p class="description">' . __('اگر فعال باشد، قیمت و دکمه‌های خرید محصولات مخفی خواهند شد.', 'seokar') . '</p>';
        },
        'seokar_theme_options',
        'seokar_theme_main_section'
    );

    add_settings_field(
        'seokar_hide_product_reviews',
        __('مخفی کردن نظرات محصولات', 'seokar'),
        function() {
            $value = get_option('seokar_hide_product_reviews', false);
            echo '<input type="checkbox" name="seokar_hide_product_reviews" value="1" ' . checked(1, $value, false) . '>';
            echo '<p class="description">' . __('اگر فعال باشد، تب نظرات در صفحات محصولات مخفی خواهد شد.', 'seokar') . '</p>';
        },
        'seokar_theme_options',
        'seokar_theme_main_section'
    );
}
register_setting('seokar_theme_settings', 'seokar_show_sidebar_posts');
register_setting('seokar_theme_settings', 'seokar_show_sidebar_archives');
register_setting('seokar_theme_settings', 'seokar_show_sidebar_products');

add_settings_field(
    'seokar_show_sidebar_posts',
    __('نمایش سایدبار در نوشته‌ها', 'seokar'),
    function() {
        $value = get_option('seokar_show_sidebar_posts', true);
        echo '<input type="checkbox" name="seokar_show_sidebar_posts" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر غیرفعال باشد، سایدبار در صفحات نوشته‌ها نمایش داده نمی‌شود.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

add_settings_field(
    'seokar_show_sidebar_archives',
    __('نمایش سایدبار در صفحات بایگانی', 'seokar'),
    function() {
        $value = get_option('seokar_show_sidebar_archives', true);
        echo '<input type="checkbox" name="seokar_show_sidebar_archives" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر غیرفعال باشد، سایدبار در صفحات دسته‌بندی و بایگانی نمایش داده نمی‌شود.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

if (class_exists('WooCommerce')) {
    add_settings_field(
        'seokar_show_sidebar_products',
        __('نمایش سایدبار در صفحات محصول', 'seokar'),
        function() {
            $value = get_option('seokar_show_sidebar_products', true);
            echo '<input type="checkbox" name="seokar_show_sidebar_products" value="1" ' . checked(1, $value, false) . '>';
            echo '<p class="description">' . __('اگر غیرفعال باشد، سایدبار در صفحات محصول ووکامرس نمایش داده نمی‌شود.', 'seokar') . '</p>';
        },
        'seokar_theme_options',
        'seokar_theme_main_section'
    );
}

register_setting('seokar_theme_settings', 'seokar_ad_header');
register_setting('seokar_theme_settings', 'seokar_ad_footer');
register_setting('seokar_theme_settings', 'seokar_ad_between_posts');

add_settings_field(
    'seokar_ad_header',
    __('تبلیغ در هدر', 'seokar'),
    function() {
        $value = get_option('seokar_ad_header', '');
        echo '<input type="text" name="seokar_ad_header" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('لینک تصویر تبلیغاتی برای نمایش در هدر.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

add_settings_field(
    'seokar_ad_footer',
    __('تبلیغ در فوتر', 'seokar'),
    function() {
        $value = get_option('seokar_ad_footer', '');
        echo '<input type="text" name="seokar_ad_footer" value="' . esc_attr($value) . '" class="regular-text">';
        echo '<p class="description">' . __('لینک تصویر تبلیغاتی برای نمایش در فوتر.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);
register_setting('seokar_theme_settings', 'seokar_disable_rss');
add_settings_field(
    'seokar_disable_rss',
    __('غیرفعال‌سازی فید RSS', 'seokar'),
    function() {
        $value = get_option('seokar_disable_rss', false);
        echo '<input type="checkbox" name="seokar_disable_rss" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('با فعال کردن این گزینه، فید RSS سایت غیرفعال می‌شود.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);
register_setting('seokar_theme_settings', 'seokar_enable_amp');
add_settings_field(
    'seokar_enable_amp',
    __('فعال‌سازی AMP', 'seokar'),
    function() {
        $value = get_option('seokar_enable_amp', false);
        echo '<input type="checkbox" name="seokar_enable_amp" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، نسخه AMP صفحات ایجاد خواهد شد.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);
function seokar_get_post_views($postID) {
    $count = get_post_meta($postID, 'seokar_post_views', true);
    if ($count == '') {
        delete_post_meta($postID, 'seokar_post_views');
        add_post_meta($postID, 'seokar_post_views', '0');
        return "0 بازدید";
    }
    return $count . ' بازدید';
}

function seokar_set_post_views($postID) {
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
add_action('wp_head', function() {
    if (is_single()) {
        seokar_set_post_views(get_the_ID());
    }
});
register_setting('seokar_theme_settings', 'seokar_enable_sitemap');
add_settings_field(
    'seokar_enable_sitemap',
    __('فعال‌سازی نقشه سایت XML', 'seokar'),
    function() {
        $value = get_option('seokar_enable_sitemap', false);
        echo '<input type="checkbox" name="seokar_enable_sitemap" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، نقشه سایت XML به‌صورت خودکار ایجاد می‌شود.', 'seokar') . '</p>';
    },
    'seokar_theme_options',
    'seokar_theme_main_section'
);

function seokar_generate_sitemap() {
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
add_action('save_post', 'seokar_generate_sitemap');

// مقداردهی اولیه کلاس
Seokar_Theme_Options::get_instance();
