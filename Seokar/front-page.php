<?php
/**
 * Front Page Template - Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">

    <!-- 🔥 هدر صفحه اصلی -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
                <p><?php echo esc_html(get_bloginfo('description')); ?></p>
                <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn-primary">
                    <?php esc_html_e('مشاهده مقالات', 'seokar'); ?>
                </a>
            </div>
            <div class="hero-image">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-image.webp'); ?>" alt="<?php esc_attr_e('SEO Optimization', 'seokar'); ?>" width="600" height="400" loading="lazy">
            </div>
        </div>
    </section>

    <!-- 🚀 بخش ویژگی‌ها -->
    <section class="features-section">
        <div class="container">
            <h2><?php esc_html_e('چرا Seokar را انتخاب کنیم؟', 'seokar'); ?></h2>
            <div class="features-grid">
                <?php
                $features = [
                    ['icon' => 'icon-speedometer', 'title' => 'سرعت بالا', 'desc' => 'بهینه‌شده برای بارگذاری سریع و امتیاز بالا در PageSpeed.'],
                    ['icon' => 'icon-seo', 'title' => 'سئوی قوی', 'desc' => 'ساختار استاندارد و کدنویسی بهینه برای موتورهای جستجو.'],
                    ['icon' => 'icon-responsive', 'title' => 'واکنش‌گرا', 'desc' => 'نمایش عالی در موبایل، تبلت و دسکتاپ.']
                ];
                foreach ($features as $feature) :
                ?>
                    <div class="feature-item">
                        <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 📝 آخرین مقالات -->
    <section class="latest-posts">
        <div class="container">
            <h2><?php esc_html_e('آخرین مقالات', 'seokar'); ?></h2>
            <div class="post-grid">
                <?php
                $latest_posts = new WP_Query([
                    'posts_per_page' => 3,
                    'post_status'    => 'publish'
                ]);
                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('medium', ['loading' => 'lazy', 'width' => '300', 'height' => '200']);
                                } else { ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.webp'); ?>" alt="<?php the_title_attribute(); ?>" width="300" height="200" loading="lazy">
                                <?php } ?>
                            </a>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('ادامه مطلب', 'seokar'); ?></a>
                            </div>
                        </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . esc_html__('مقاله‌ای یافت نشد.', 'seokar') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- 📢 بخش نظرات کاربران -->
    <section class="testimonials">
        <div class="container">
            <h2><?php esc_html_e('نظرات کاربران', 'seokar'); ?></h2>
            <div class="testimonial-slider">
                <?php
                $testimonials = [
                    ['name' => 'علی رضایی', 'text' => 'قالب فوق‌العاده سریع و سئو شده. کاملاً پیشنهاد می‌کنم!'],
                    ['name' => 'زهرا احمدی', 'text' => 'پشتیبانی عالی و امکانات بی‌نظیر.'],
                    ['name' => 'محمد نوری', 'text' => 'خیلی سبکه و بهینه شده برای گوگل.']
                ];
                foreach ($testimonials as $testimonial) :
                ?>
                    <div class="testimonial-item">
                        <p><?php echo esc_html($testimonial['text']); ?></p>
                        <h4><?php echo esc_html($testimonial['name']); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ✅ فراخوانی به اقدام (CTA) -->
    <section class="cta-section">
        <div class="container">
            <h2><?php esc_html_e('وب‌سایت خود را با Seokar بهینه کنید!', 'seokar'); ?></h2>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">
                <?php esc_html_e('مشاوره رایگان سئو', 'seokar'); ?>
            </a>
        </div>
    </section>

</main>

<?php
get_footer();
?>
