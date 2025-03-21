<?php
/**
 * Register Widgets for Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

function seokar_register_widgets() {
    register_sidebar(array(
        'name'          => __('سایدبار اصلی', 'seokar'),
        'id'            => 'main-sidebar',
        'description'   => __('ابزارک‌های نمایش داده شده در سایدبار اصلی سایت', 'seokar'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('فوتر 1', 'seokar'),
        'id'            => 'footer-1',
        'description'   => __('ابزارک اول در فوتر', 'seokar'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('فوتر 2', 'seokar'),
        'id'            => 'footer-2',
        'description'   => __('ابزارک دوم در فوتر', 'seokar'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('فوتر 3', 'seokar'),
        'id'            => 'footer-3',
        'description'   => __('ابزارک سوم در فوتر', 'seokar'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'seokar_register_widgets');
