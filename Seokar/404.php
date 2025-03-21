<?php
/**
 * 404 Page Template - Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="container">
    <div class="error-404">
        <div class="error-content">
            <h1 class="error-title"><?php _e('اوه! صفحه مورد نظر یافت نشد.', 'seokar'); ?></h1>
            <p class="error-message"><?php _e('متأسفیم، اما صفحه‌ای که به دنبال آن هستید وجود ندارد. شاید از طریق جستجو پیدا کنید؟', 'seokar'); ?></p>

            <!-- فرم جستجو -->
            <div class="search-form">
                <?php get_search_form(); ?>
            </div>

            <!-- دکمه بازگشت به صفحه اصلی -->
            <div class="back-to-home">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                    <?php _e('بازگشت به صفحه اصلی', 'seokar'); ?>
                </a>
            </div>
        </div>

        <!-- تصویر 404 -->
        <div class="error-image">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/404.svg'); ?>" alt="404 Not Found">
        </div>
    </div>
</div>

<?php get_footer(); ?>
