<?php
/**
 * مدیریت تبدیل تصاویر به WebP در قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit; // خروج در صورت دسترسی مستقیم به فایل
}

class Seokar_WebP {
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // افزودن هوک‌ها
        add_filter('wp_generate_attachment_metadata', array($this, 'generate_webp_on_upload'), 10, 2);
        add_filter('the_content', array($this, 'replace_images_with_webp'));
        add_filter('post_thumbnail_html', array($this, 'replace_thumbnail_with_webp'), 10, 5);
        add_action('admin_init', array($this, 'register_webp_settings'));
    }

    // بررسی پشتیبانی مرورگر از WebP
    public function supports_webp() {
        return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }

    // ایجاد نسخه WebP هنگام آپلود تصویر
    public function generate_webp_on_upload($metadata, $attachment_id) {
        $file_path = get_attached_file($attachment_id);
        $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        // اگر فرمت تصویر مجاز نبود یا WebP غیرفعال است، ادامه نده
        if (!in_array(strtolower($file_ext), $allowed_extensions) || !$this->is_webp_enabled()) {
            return $metadata;
        }

        $webp_path = str_replace('.' . $file_ext, '.webp', $file_path);

        // اگر فایل WebP از قبل وجود ندارد، آن را ایجاد کن
        if (!file_exists($webp_path)) {
            $image = $this->create_image_resource($file_path, $file_ext);
            if ($image !== false) {
                $quality = $this->get_webp_quality(); // کیفیت WebP از تنظیمات
                imagewebp($image, $webp_path, $quality);
                imagedestroy($image);
            }
        }

        return $metadata;
    }

    // ایجاد منبع تصویر بر اساس فرمت
    private function create_image_resource($file_path, $file_ext) {
        switch (strtolower($file_ext)) {
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($file_path);
            case 'png':
                $image = imagecreatefrompng($file_path);
                imagepalettetotruecolor($image); // تبدیل پالت به رنگ‌های واقعی برای PNG
                imagealphablending($image, true); // فعال‌سازی شفافیت
                imagesavealpha($image, true); // ذخیره شفافیت
                return $image;
            default:
                return false;
        }
    }

    // جایگزینی تصاویر در محتوای پست‌ها با WebP
    public function replace_images_with_webp($content) {
        if (!$this->supports_webp() || !$this->is_webp_enabled()) {
            return $content;
        }

        return preg_replace_callback('/<img[^>]+src=["\']([^"\']+)\.(jpg|jpeg|png)["\']/i', function ($matches) {
            $webp_url = $matches[1] . '.webp';
            if (file_exists($this->convert_url_to_path($webp_url))) {
                return str_replace($matches[1] . '.' . $matches[2], $webp_url, $matches[0]);
            }
            return $matches[0];
        }, $content);
    }

    // جایگزینی تصاویر شاخص با WebP
    public function replace_thumbnail_with_webp($html, $post_id, $post_thumbnail_id, $size, $attr) {
        if (!$this->supports_webp() || !$this->is_webp_enabled()) {
            return $html;
        }

        $img_src = wp_get_attachment_image_src($post_thumbnail_id, $size);
        if (!$img_src) {
            return $html;
        }

        $webp_src = str_replace(array('.jpg', '.jpeg', '.png'), '.webp', $img_src[0]);
        if (file_exists($this->convert_url_to_path($webp_src))) {
            $html = str_replace($img_src[0], $webp_src, $html);
        }

        return $html;
    }

    // تبدیل URL به مسیر فیزیکی فایل در سرور
    private function convert_url_to_path($url) {
        return str_replace(get_site_url(), ABSPATH, $url);
    }

    // ثبت تنظیمات WebP در پیشخوان وردپرس
    public function register_webp_settings() {
        register_setting('seokar_webp_settings', 'seokar_webp_enabled');
        register_setting('seokar_webp_settings', 'seokar_webp_quality');

        add_settings_section(
            'seokar_webp_main_section',
            __('تنظیمات WebP', 'seokar'),
            '__return_false',
            'seokar_webp_options'
        );

        add_settings_field(
            'seokar_webp_enabled',
            __('فعال‌سازی WebP', 'seokar'),
            array($this, 'webp_enabled_callback'),
            'seokar_webp_options',
            'seokar_webp_main_section'
        );

        add_settings_field(
            'seokar_webp_quality',
            __('کیفیت WebP', 'seokar'),
            array($this, 'webp_quality_callback'),
            'seokar_webp_options',
            'seokar_webp_main_section'
        );
    }

    // فیلد فعال‌سازی WebP
    public function webp_enabled_callback() {
        $value = get_option('seokar_webp_enabled', true);
        echo '<input type="checkbox" name="seokar_webp_enabled" value="1" ' . checked(1, $value, false) . '>';
        echo '<p class="description">' . __('اگر فعال باشد، تصاویر به فرمت WebP تبدیل می‌شوند.', 'seokar') . '</p>';
    }

    // فیلد کیفیت WebP
    public function webp_quality_callback() {
        $value = get_option('seokar_webp_quality', 85);
        echo '<input type="number" name="seokar_webp_quality" value="' . esc_attr($value) . '" min="1" max="100">';
        echo '<p class="description">' . __('کیفیت تصاویر WebP (بین ۱ تا ۱۰۰).', 'seokar') . '</p>';
    }

    // بررسی فعال بودن WebP
    private function is_webp_enabled() {
        return get_option('seokar_webp_enabled', true);
    }

    // دریافت کیفیت WebP
    private function get_webp_quality() {
        return get_option('seokar_webp_quality', 85);
    }
}

// مقداردهی اولیه کلاس
Seokar_WebP::get_instance();
