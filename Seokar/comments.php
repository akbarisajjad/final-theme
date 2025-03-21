<?php
/**
 * Comments Template - Seokar Theme
 *
 * @package Seokar
 */

if (!defined('ABSPATH')) {
    exit;
}

// اگر نظرات بسته باشد، هیچی نمایش نده
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <h2 class="comments-title">
        <?php
        $comment_count = get_comments_number();
        if ($comment_count === 0) {
            _e('بدون دیدگاه', 'seokar');
        } else {
            printf(_n('%s دیدگاه', '%s دیدگاه', $comment_count, 'seokar'), number_format_i18n($comment_count));
        }
        ?>
    </h2>

    <!-- لیست نظرات -->
    <?php if (have_comments()) : ?>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 64,
                'callback'    => 'seokar_custom_comment_format',
            ));
            ?>
        </ol>

        <!-- صفحه‌بندی نظرات -->
        <div class="comments-pagination">
            <?php paginate_comments_links(); ?>
        </div>

    <?php endif; ?>

    <!-- فرم ارسال نظر -->
    <?php if (comments_open()) : ?>
        <div class="comment-form-container">
            <?php
            $comment_form_args = array(
                'title_reply'         => __('نظر خود را ثبت کنید', 'seokar'),
                'title_reply_before'  => '<h3 class="comment-form-title">',
                'title_reply_after'   => '</h3>',
                'comment_notes_after' => '',
                'class_submit'        => 'btn-primary',
                'label_submit'        => __('ارسال دیدگاه', 'seokar'),
                'fields'              => apply_filters('comment_form_default_fields', array(
                    'author' => '<div class="comment-form-field"><label for="author">' . __('نام:', 'seokar') . '</label> ' .
                        '<input id="author" name="author" type="text" required></div>',
                    'email'  => '<div class="comment-form-field"><label for="email">' . __('ایمیل:', 'seokar') . '</label> ' .
                        '<input id="email" name="email" type="email" required></div>',
                )),
                'comment_field' => '<div class="comment-form-field"><label for="comment">' . __('متن دیدگاه:', 'seokar') . '</label> ' .
                    '<textarea id="comment" name="comment" rows="4" required></textarea></div>',
            );

            comment_form($comment_form_args);
            ?>
        </div>
    <?php endif; ?>
</div>
