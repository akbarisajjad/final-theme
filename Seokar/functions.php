<?php
/**
 * Functions and Definitions - Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

// ۱. تنظیمات اولیه قالب
function seokar_theme_setup() {
    // پشتیبانی از تصاویر شاخص
    add_theme_support('post-thumbnails');

    // ثبت منوها
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'seokar'),
        'footer'  => __('منوی فوتر', 'seokar'),
    ));

    // پشتیبانی از لوگوی سفارشی
    add_theme_support('custom-logo', array(
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // پشتیبانی از عنوان داینامیک سایت
    add_theme_support('title-tag');

    // پشتیبانی از HTML5 در فرم‌ها و گالری‌ها
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // پشتیبانی از فید RSS
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'seokar_theme_setup');

// ۲. لود فایل‌های استایل و جاوا اسکریپت
function seokar_enqueue_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    // فایل‌های CSS
    wp_enqueue_style('seokar-style', get_stylesheet_uri(), array(), $theme_version);
    wp_enqueue_style('seokar-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), $theme_version);

    // فایل‌های جاوا اسکریپت
    wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), $theme_version, true);
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_scripts');

// ۳. ثبت سایدبارها و ابزارک‌ها
function seokar_widgets_init() {
    register_sidebar(array(
        'name'          => __('سایدبار اصلی', 'seokar'),
        'id'            => 'main-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'seokar_widgets_init');

// ۴. افزودن کلاس به لینک‌های منو
function seokar_nav_menu_class($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'seokar_nav_menu_class', 10, 3);

// ۵. تغییر طول خلاصه نوشته‌ها
function seokar_excerpt_length($length) {
    return 25; // تعداد کلمات خلاصه
}
add_filter('excerpt_length', 'seokar_excerpt_length');

// ۶. افزودن دکمه "ادامه مطلب" به خلاصه نوشته‌ها
function seokar_excerpt_more($more) {
    return '... <a class="read-more" href="' . get_permalink() . '">' . __('ادامه مطلب', 'seokar') . '</a>';
}
add_filter('excerpt_more', 'seokar_excerpt_more');

// ۷. امنیت: حذف ورژن وردپرس از سورس کد
function seokar_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'seokar_remove_wp_version');

// ۸. افزودن قابلیت بارگذاری فونت سفارشی
function seokar_custom_fonts() {
    echo '<style>
        @font-face {
            font-family: "CustomFont";
            src: url("' . get_template_directory_uri() . '/assets/fonts/custom-font.woff2") format("woff2");
            font-weight: normal;
            font-style: normal;
        }
        body { font-family: "CustomFont", sans-serif; }
    </style>';
}
add_action('wp_head', 'seokar_custom_fonts');

// تنظیمات اولیه قالب
require_once get_template_directory() . '/inc/setup.php';

// بارگذاری استایل‌ها و اسکریپت‌ها
require_once get_template_directory() . '/inc/enqueue.php';

// بارگذاری توابع عمومی قالب
require_once get_template_directory() . '/inc/theme-functions.php';

// مدیریت هوک‌های قالب
require_once get_template_directory() . '/inc/theme-hooks.php';

// تنظیمات سئو
require_once get_template_directory() . '/inc/seo.php';

// توابع امنیتی
require_once get_template_directory() . '/inc/security.php';

// پشتیبانی از زبان‌های مختلف
require_once get_template_directory() . '/inc/i18n.php';

// مدیریت نقش‌های کاربران
require_once get_template_directory() . '/inc/user-roles.php';

// مدیریت درخواست‌های AJAX
require_once get_template_directory() . '/inc/ajax.php';

// بارگذاری APIهای REST
require_once get_template_directory() . '/inc/rest-api.php';

// مدیریت کش و بهینه‌سازی
require_once get_template_directory() . '/inc/caching.php';
require_once get_template_directory() . '/inc/optimization.php';

// ابزارهای اشکال‌زدایی و دیباگ
require_once get_template_directory() . '/inc/debug.php';

// سازگاری با مرورگرهای قدیمی
require_once get_template_directory() . '/inc/legacy-browsers.php';

// مدیریت دسترس‌پذیری
require_once get_template_directory() . '/inc/accessibility.php';

// پشتیبانی از قابلیت چند سایتی (Multisite)
require_once get_template_directory() . '/inc/multisite.php';

// پشتیبانی از فیلدهای سفارشی
require_once get_template_directory() . '/inc/custom-fields.php';

// پشتیبانی از محتوای سفارشی (CPT و Taxonomies)
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/custom-taxonomies.php';

// مدیریت شورت‌کدها
require_once get_template_directory() . '/inc/shortcodes.php';

// پشتیبانی از WebP
require_once get_template_directory() . '/inc/webp.php';

// مدیریت خطاها
require_once get_template_directory() . '/inc/error-handling.php';

// مدیریت تنظیمات قالب
require_once get_template_directory() . '/inc/theme-options.php';

// پنل تنظیمات وردپرس (Customizer)
require_once get_template_directory() . '/config/customizer.php';

// بارگذاری ابزارک‌های سفارشی
require_once get_template_directory() . '/widgets/custom-widget.php';
require_once get_template_directory() . '/widgets/widget-functions.php';
require_once get_template_directory() . '/widgets/widgets.php';
// مدیریت کامپوننت‌های بلوک گوتنبرگ
require_once get_template_directory() . '/blocks/custom-block-1/render.php';
require_once get_template_directory() . '/blocks/custom-block-2/render.php';

// بارگذاری دستورات CLI سفارشی
require_once get_template_directory() . '/cli/custom-cli-commands.php';

// مدیریت فایل‌های ووکامرس (اگر فعال باشد)
if (class_exists('WooCommerce')) {
    require_once get_template_directory() . '/woocommerce/woocommerce-functions.php';
}

// توابع کمکی دیگر می‌توانند در اینجا اضافه شوند...

?>
