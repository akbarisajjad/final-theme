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
    add_theme_support('post-thumbnails'); // پشتیبانی از تصاویر شاخص
    add_theme_support('title-tag'); // پشتیبانی از عنوان داینامیک
    add_theme_support('automatic-feed-links'); // پشتیبانی از فید RSS
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption')); // پشتیبانی از HTML5
    add_theme_support('custom-logo', array( // پشتیبانی از لوگوی سفارشی
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // ثبت منوهای قالب
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'seokar'),
        'footer'  => __('منوی فوتر', 'seokar'),
    ));
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

// ۹. بارگذاری فایل‌های ضروری قالب از `inc/`
$seokar_includes = array(
    'setup.php', 'enqueue.php', 'theme-functions.php', 'theme-hooks.php', 'seo.php', 
    'security.php', 'i18n.php', 'user-roles.php', 'ajax.php', 'rest-api.php', 
    'caching.php', 'optimization.php', 'debug.php', 'legacy-browsers.php', 
    'accessibility.php', 'multisite.php', 'custom-fields.php', 
    'custom-post-types.php', 'custom-taxonomies.php', 'shortcodes.php', 
    'webp.php', 'error-handling.php', 'theme-options.php'
);
foreach ($seokar_includes as $file) {
    require_once get_template_directory() . '/inc/' . $file;
}

// ۱۰. بارگذاری تنظیمات و سفارشی‌سازی قالب
require_once get_template_directory() . '/config/customizer.php';

// ۱۱. بارگذاری ابزارک‌های سفارشی
$seokar_widgets = array('custom-widget.php', 'widget-functions.php', 'widgets.php');
foreach ($seokar_widgets as $widget) {
    require_once get_template_directory() . '/widgets/' . $widget;
}

// ۱۲. بارگذاری بلوک‌های گوتنبرگ
$seokar_blocks = array('custom-block-1/render.php', 'custom-block-2/render.php');
foreach ($seokar_blocks as $block) {
    require_once get_template_directory() . '/blocks/' . $block;
}

// ۱۳. بارگذاری دستورات CLI سفارشی
require_once get_template_directory() . '/cli/custom-cli-commands.php';

// ۱۴. بررسی و بارگذاری ووکامرس (اگر فعال باشد)
if (class_exists('WooCommerce')) {
    require_once get_template_directory() . '/woocommerce/woocommerce-functions.php';
}
// 📌 اضافه کردن لینک manifest.json به هدر وردپرس
function add_manifest_link() {
    echo '<link rel="manifest" href="' . get_template_directory_uri() . '/manifest.json">';
}
add_action('wp_head', 'add_manifest_link');

// 📌 ثبت Service Worker در وردپرس
function register_service_worker() {
    ?>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?php echo get_template_directory_uri(); ?>/service-worker.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
    <?php
}
add_action('wp_footer', 'register_service_worker');
require_once get_template_directory() . '/admin/admin-menu.php';
?>
