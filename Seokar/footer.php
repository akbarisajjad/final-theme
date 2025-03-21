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
                <div class="footer-widget" loading="lazy">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget" loading="lazy">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="footer-widget" loading="lazy">
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

<!-- نوار نصب اپلیکیشن PWA -->
<div id="pwa-install-banner" class="pwa-banner" style="display: none;">
    <div class="pwa-content">
        <span>نصب اپلیکیشن سئوکار</span>
        <button id="pwa-install-btn" class="pwa-btn">نصب</button>
        <button id="pwa-close-btn" class="pwa-close">×</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    let installPromptEvent;
    const installBanner = document.getElementById("pwa-install-banner");
    const installBtn = document.getElementById("pwa-install-btn");
    const closeBtn = document.getElementById("pwa-close-btn");

    // بررسی پشتیبانی از PWA و جلوگیری از نمایش دوباره
    if (!localStorage.getItem("pwaInstalled")) {
        window.addEventListener("beforeinstallprompt", (event) => {
            event.preventDefault();
            installPromptEvent = event;
            installBanner.style.display = "flex";
        });
    }

    // کلیک روی دکمه نصب
    installBtn.addEventListener("click", () => {
        if (installPromptEvent) {
            installPromptEvent.prompt();
            installPromptEvent.userChoice.then((choice) => {
                if (choice.outcome === "accepted") {
                    console.log("User installed PWA");
                    localStorage.setItem("pwaInstalled", "true"); // جلوگیری از نمایش دوباره
                }
                installBanner.style.display = "none";
            });
        }
    });

    // بستن نوار نصب
    closeBtn.addEventListener("click", () => {
        installBanner.style.display = "none";
    });
});
</script>

</body>
</html>
