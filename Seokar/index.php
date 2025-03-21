<?php
/**
 * Main Blog Page Template
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
            
            <header class="archive-header">
                <h1 class="archive-title"><?php _e('آخرین مقالات', 'seokar'); ?></h1>
                <p class="archive-description"><?php _e('جدیدترین مطالب سایت را اینجا بخوانید.', 'seokar'); ?></p>
            </header>

            <?php if (have_posts()) : ?>
                <div class="post-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            
                            <header class="post-header">
                                <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                    <?php if (has_post_thumbnail()) {
                                        the_post_thumbnail('seokar-thumbnail', ['loading' => 'lazy']);
                                    } else { ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.jpg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    <?php } ?>
                                </a>
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                            </header>

                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-author"><?php the_author(); ?></span>
                                <span class="post-comments">
                                    <?php comments_number(__('بدون دیدگاه', 'seokar'), __('یک دیدگاه', 'seokar'), __('% دیدگاه', 'seokar')); ?>
                                </span>
                                <span class="post-category">
                                    <?php the_category(', '); ?>
                                </span>
                            </div>

                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('ادامه مطلب', 'seokar'); ?></a>
                            </footer>

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
                <p class="no-posts"><?php _e('محتوایی یافت نشد.', 'seokar'); ?></p>
            <?php endif; ?>
        </main>

        <!-- نمایش سایدبار -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
