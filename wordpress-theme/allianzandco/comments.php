<?php
/**
 * Comments template.
 *
 * @package AllianzAndCo
 */

if ( post_password_required() ) return;
?>
<div id="comments" class="al-comments" style="margin-top: 4rem;">
    <h3 class="al-comments__title">
        <?php
        $count = get_comments_number();
        if ( $count == 0 ) {
            esc_html_e( 'Leave a comment', 'allianzandco' );
        } elseif ( $count == 1 ) {
            esc_html_e( '1 comment', 'allianzandco' );
        } else {
            printf( esc_html( _n( '%s comment', '%s comments', $count, 'allianzandco' ) ), number_format_i18n( $count ) );
        }
        ?>
    </h3>

    <?php if ( have_comments() ) : ?>
        <ol class="al-comment-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1.5rem;">
            <?php wp_list_comments( array( 'callback' => 'al_comment_callback', 'style' => 'ol' ) ); ?>
        </ol>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'         => esc_html__( 'Add a comment', 'allianzandco' ),
        'title_reply_before'  => '<h4 id="reply-title" class="al-comment-reply-title">',
        'title_reply_after'   => '</h4>',
        'submit_button'       => '<button type="submit" name="%1$s" id="%2$s" class="al-btn al-btn--sm %3$s">%4$s</button>',
        'comment_notes_after' => '',
        'class_form'          => 'al-form al-comment-form',
        'comment_field'       => '<div class="al-field"><label for="comment">' . esc_html__( 'Comment', 'allianzandco' ) . '</label><textarea id="comment" name="comment" rows="6" required></textarea></div>',
    ) );
    ?>
</div>
