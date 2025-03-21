<?php
/**
 * Sidebar Template
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

// بررسی اینکه آیا سایدبار دارای ابزارک فعال است
if (!is_active_sidebar('main-sidebar')) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <div class="container">
        <?php dynamic_sidebar('main-sidebar'); ?>
    </div>
</aside>
