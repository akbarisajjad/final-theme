<?php
/**
 * Footer Template
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    </main><!-- #content -->

    <!-- فوتر سایت -->
    <footer id="colophon" class="site-footer">
        <div class="container">

            <!-- ابزارک‌های فوتر -->
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- کپی‌رایت و لینک‌های فوتر -->
            <div class="footer-bottom">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> 
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a> - تمامی حقوق محفوظ است.
                </p>

                <nav class="footer-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => 'ul',
                        'menu_class'     => 'nav-footer',
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

</body>
</html>
