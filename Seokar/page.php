<?php
/**
 * Page Template
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
                <article id="page-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>

                    <!-- تصویر شاخص -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="page-thumbnail">
                            <?php the_post_thumbnail('seokar-banner', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- عنوان برگه -->
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <!-- محتوای برگه -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- نمایش نظرات (در صورت فعال بودن) -->
                    <?php if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif; ?>

                </article>
            <?php endwhile; ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
