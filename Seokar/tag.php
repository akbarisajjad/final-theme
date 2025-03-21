<?php
/**
 * Tag Archive Template - Seokar Theme
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

            <!-- عنوان برچسب -->
            <header class="tag-header">
                <h1 class="tag-title">
                    <?php printf(__('مطالب دارای برچسب: %s', 'seokar'), single_tag_title('', false)); ?>
                </h1>
                <?php if (tag_description()) : ?>
                    <p class="tag-description"><?php echo tag_description(); ?></p>
                <?php endif; ?>
            </header>

            <!-- نمایش مطالب دارای این برچسب -->
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
                <p class="no-posts"><?php _e('متأسفیم! هیچ مطلبی با این برچسب یافت نشد.', 'seokar'); ?></p>
            <?php endif; ?>
        </main>

        <!-- نمایش سایدبار -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
