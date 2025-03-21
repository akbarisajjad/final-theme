<?php
/**
 * Archive Template - Seokar Theme (Professional Version)
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

            <!-- هدر آرشیو -->
            <header class="archive-header">
                <h1 class="archive-title">
                    <?php
                    if (is_category()) {
                        printf(__('مطالب دسته: %s', 'seokar'), single_cat_title('', false));
                    } elseif (is_tag()) {
                        printf(__('مطالب برچسب: %s', 'seokar'), single_tag_title('', false));
                    } elseif (is_author()) {
                        printf(__('نوشته‌های %s', 'seokar'), get_the_author());
                    } elseif (is_year()) {
                        printf(__('آرشیو سال %s', 'seokar'), get_the_date('Y'));
                    } elseif (is_month()) {
                        printf(__('آرشیو %s', 'seokar'), get_the_date('F Y'));
                    } elseif (is_day()) {
                        printf(__('آرشیو %s', 'seokar'), get_the_date('F j, Y'));
                    } else {
                        _e('آرشیو مطالب', 'seokar');
                    }
                    ?>
                </h1>
                <p class="archive-count"><?php printf(__('تعداد مطالب: %s', 'seokar'), $wp_query->found_posts); ?></p>
            </header>

            <!-- فیلتر دسته‌بندی و تاریخ -->
            <div class="filter-container">
                <form id="archive-filter" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <select name="cat" onchange="this.form.submit()">
                        <option value=""><?php _e('انتخاب دسته‌بندی', 'seokar'); ?></option>
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                        }
                        ?>
                    </select>

                    <select name="year" onchange="this.form.submit()">
                        <option value=""><?php _e('انتخاب سال', 'seokar'); ?></option>
                        <?php
                        global $wpdb;
                        $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC");
                        foreach ($years as $year) {
                            echo '<option value="' . esc_attr($year) . '">' . esc_html($year) . '</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>

            <!-- نمایش مطالب -->
            <?php if (have_posts()) : ?>
                <div id="post-container" class="post-grid">
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

                <!-- صفحه‌بندی AJAX -->
                <div id="pagination-container">
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
