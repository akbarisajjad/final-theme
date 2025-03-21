<?php
/**
 * Author Archive Template - Seokar Theme
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

            <!-- اطلاعات نویسنده -->
            <header class="author-header">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 120); ?>
                </div>
                <h1 class="author-title"><?php printf(__('نوشته‌های %s', 'seokar'), get_the_author()); ?></h1>
                <?php if (get_the_author_meta('description')) : ?>
                    <p class="author-bio"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                <?php endif; ?>

                <!-- لینک‌های شبکه‌های اجتماعی نویسنده (در صورت وجود) -->
                <div class="author-social">
                    <?php if (get_the_author_meta('twitter')) : ?>
                        <a href="<?php echo esc_url(get_the_author_meta('twitter')); ?>" target="_blank">توییتر</a>
                    <?php endif; ?>
                    <?php if (get_the_author_meta('linkedin')) : ?>
                        <a href="<?php echo esc_url(get_the_author_meta('linkedin')); ?>" target="_blank">لینکدین</a>
                    <?php endif; ?>
                </div>
            </header>

            <!-- نمایش مطالب نویسنده -->
            <?php if (have_posts()) : ?>
                <div class="post-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item animated-fade-in'); ?>>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('seokar-thumbnail', ['loading' => 'lazy']);
                                } else { ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.jpg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                <?php } ?>
                            </a>
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-meta">
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                    <span class="post-author"><?php the_author(); ?></span>
                                </div>
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('ادامه مطلب', 'seokar'); ?></a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- صفحه‌بندی -->
                <div class="pagination">
                    <?php the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('« قبلی', 'seokar'),
                        'next_text' => __('بعدی »', 'seokar'),
                    )); ?>
                </div>

            <?php else : ?>
                <p class="no-posts"><?php _e('این نویسنده هنوز مطلبی منتشر نکرده است.', 'seokar'); ?></p>
            <?php endif; ?>
        </main>

        <!-- نمایش سایدبار -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
