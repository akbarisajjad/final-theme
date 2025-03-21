<?php
/**
 * Single Post Template
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
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

                    <!-- تصویر شاخص -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('seokar-banner', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- عنوان و متا اطلاعات -->
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <span class="post-author"><?php the_author_posts_link(); ?></span>
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                            <span class="post-category"><?php the_category(', '); ?></span>
                        </div>
                    </header>

                    <!-- محتوای نوشته -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- اشتراک‌گذاری در شبکه‌های اجتماعی -->
                    <div class="social-share">
                        <span><?php _e('اشتراک‌گذاری:', 'seokar'); ?></span>
                        <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank">X (توییتر)</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">فیسبوک</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>" target="_blank">لینکدین</a>
                    </div>

                    <!-- برچسب‌ها -->
                    <div class="post-tags">
                        <?php the_tags('<span class="tag-label">برچسب‌ها: </span>', ', ', ''); ?>
                    </div>

                    <!-- پیمایش بین نوشته‌ها -->
                    <div class="post-navigation">
                        <div class="nav-previous"><?php previous_post_link('%link', '← نوشته قبلی'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'نوشته بعدی →'); ?></div>
                    </div>

                    <!-- نمایش نظرات -->
                    <?php if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif; ?>

                </article>
            <?php endwhile; ?>
        </main>

        <!-- نمایش سایدبار -->
        <?php get_sidebar(); ?>
    </div>
</div>
<?php echo seokar_get_post_views(get_the_ID()); ?>
<?php get_footer(); ?>
