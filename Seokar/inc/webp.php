<?php
/**
 * مدیریت تبدیل تصاویر به WebP در قالب Seokar
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
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
        add_filter('wp_generate_attachment_metadata', array($this, 'generate_webp_on_upload'), 10, 2);
        add_filter('the_content', array($this, 'replace_images_with_webp'));
        add_filter('post_thumbnail_html', array($this, 'replace_thumbnail_with_webp'), 10, 5);
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

        if (in_array(strtolower($file_ext), $allowed_extensions)) {
            $webp_path = str_replace('.' . $file_ext, '.webp', $file_path);

            if (!file_exists($webp_path)) {
                $image = $this->create_image_resource($file_path, $file_ext);
                if ($image !== false) {
                    imagewebp($image, $webp_path, 85);
                    imagedestroy($image);
                }
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
                return imagecreatefrompng($file_path);
            default:
                return false;
        }
    }

    // جایگزینی تصاویر در محتوای پست‌ها با WebP
    public function replace_images_with_webp($content) {
        if (!$this->supports_webp()) {
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
        if (!$this->supports_webp()) {
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
}

// مقداردهی اولیه کلاس
Seokar_WebP::get_instance();
