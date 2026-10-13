<?php
/**
 * Main index / fallback template.
 *
 * @package AllianzAndCo
 */
get_header(); ?>

<section class="al-section" style="padding-top: calc(var(--al-header-h) + 3rem);">
    <div class="al-container">
        <?php if ( have_posts() ) : ?>
            <div class="al-grid al-grid--3">
                <?php while ( have_posts() ) : the_post();
                    $img = get_the_post_thumbnail_url( null, 'al-blog' ) ?: AL_THEME_URI . '/assets/images/blog-1.jpeg'; ?>
                    <article class="al-post-card al-reveal">
                        <a class="al-post-card__media" href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"></a>
                        <div class="al-post-card__body">
                            <h3 class="al-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="al-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="al-pagination"><?php echo paginate_links( array( 'prev_text' => '&larr;', 'next_text' => '&rarr;', 'type' => 'plain' ) ); ?></div>
        <?php else : ?>
            <p class="al-text-center"><?php esc_html_e( 'Nothing found.', 'allianzandco' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();
