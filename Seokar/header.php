<?php
/**
 * Header Template
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="robots" content="index, follow">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/favicon.svg'); ?>" type="image/svg+xml">
    
    <!-- پشتیبانی از حالت تاریک -->
    <script>
        document.documentElement.dataset.theme = localStorage.getItem('theme') || 'light';
    </script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <!-- حالت تاریک -->
    <div class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="تغییر حالت تاریک">
        <span class="toggle-icon"></span>
    </div>

    <header id="masthead" class="site-header">
        <div class="container">
            <!-- برندینگ و لوگو -->
            <div class="site-branding">
                <?php if (has_custom_logo()) { ?>
                    <div class="logo"><?php the_custom_logo(); ?></div>
                <?php } else { ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php } ?>
            </div>

            <!-- دکمه منوی موبایل -->
            <button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="hamburger"></span>
            </button>

            <!-- منوی ناوبری -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Main Menu', 'seokar'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => 'ul',
                    'menu_class'     => 'nav-menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
        </div>
    </header>

    <!-- شروع محتوا -->
    <main id="content" class="site-content">
