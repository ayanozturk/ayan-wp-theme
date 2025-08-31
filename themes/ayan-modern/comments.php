<?php
/**
 * Comments template
 *
 * @package Ayan_Modern
 */

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number === 1) {
                printf(esc_html__('One comment on "%s"', 'ayan-modern'), get_the_title());
            } else {
                printf(
                    esc_html(_n('%1$s comment on "%2$s"', '%1$s comments on "%2$s"', $comments_number, 'ayan-modern')),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 48,
            ));
            ?>
        </ol>

        <?php
        the_comments_pagination(array(
            'prev_text'          => esc_html__('← Older comments', 'ayan-modern'),
            'next_text'          => esc_html__('Newer comments →', 'ayan-modern'),
            'screen_reader_text' => esc_html__('Comments navigation', 'ayan-modern'),
            'class'              => 'pagination comments-pagination',
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number()) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'ayan-modern'); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>
</section>


