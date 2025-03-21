<?php
/**
 * Attachment Page Template - Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="container">
    <div class="content-wrapper">
        <main id="primary" class="site-main">

            <?php while (have_posts()) : the_post(); ?>
                <article id="attachment-<?php the_ID(); ?>" <?php post_class('attachment-page'); ?>>

                    <!-- نمایش فایل پیوست -->
                    <header class="attachment-header">
                        <h1 class="attachment-title"><?php the_title(); ?></h1>
                        <p class="attachment-meta">
                            <span><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span> |
                            <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                        </p>
                    </header>

                    <div class="attachment-content">
                        <?php
                        $mime = get_post_mime_type();
                        if (strpos($mime, 'image') !== false) {
                            echo '<div class="attachment-media">' . wp_get_attachment_image(get_the_ID(), 'large') . '</div>';
                        } elseif (strpos($mime, 'video') !== false) {
                            echo '<div class="attachment-media">' . wp_video_shortcode(array('src' => wp_get_attachment_url())) . '</div>';
                        } elseif (strpos($mime, 'audio') !== false) {
                            echo '<div class="attachment-media">' . wp_audio_shortcode(array('src' => wp_get_attachment_url())) . '</div>';
                        } elseif (strpos($mime, 'pdf') !== false) {
                            echo '<div class="attachment-media"><embed src="' . esc_url(wp_get_attachment_url()) . '" type="application/pdf" width="100%" height="600px"></div>';
                        } else {
                            echo '<p>' . __('فرمت این فایل پشتیبانی نمی‌شود. لطفاً فایل را دانلود کنید.', 'seokar') . '</p>';
                        }
                        ?>
                    </div>

                    <!-- دکمه دانلود فایل -->
                    <div class="download-button">
                        <a href="<?php echo esc_url(wp_get_attachment_url()); ?>" download class="btn-primary">
                            <i class="fas fa-download"></i> <?php _e('دانلود فایل', 'seokar'); ?>
                        </a>
                    </div>

                    <!-- توضیحات و کپشن -->
                    <?php if (has_excerpt()) : ?>
                        <div class="attachment-caption">
                            <h3><?php _e('توضیحات:', 'seokar'); ?></h3>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- نویگیشن بین فایل‌های پیوست -->
                    <div class="attachment-navigation">
                        <div class="nav-previous"><?php previous_image_link(false, __('← فایل قبلی', 'seokar')); ?></div>
                        <div class="nav-next"><?php next_image_link(false, __('فایل بعدی →', 'seokar')); ?></div>
                    </div>

                </article>
            <?php endwhile; ?>

        </main>
    </div>
</div>

<?php get_footer(); ?>
