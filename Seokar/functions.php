<?php
/**
 * Seokar Theme Functions
 *
 * @package Seokar
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

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
