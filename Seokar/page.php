<?php
/**
 * Page Template - Seokar Theme
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
                            <div class="overlay"></div>
                            <?php the_post_thumbnail('seokar-banner', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- مسیر صفحه (Breadcrumbs) -->
                    <nav class="breadcrumbs">
                        <?php if (function_exists('yoast_breadcrumb')) {
                            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                        } ?>
                    </nav>

                    <!-- عنوان و اطلاعات برگه -->
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <!-- محتوای برگه -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- دکمه بازگشت به صفحه اصلی -->
                    <div class="back-to-home">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                            <?php _e('بازگشت به صفحه اصلی', 'seokar'); ?>
                        </a>
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
