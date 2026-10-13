<?php
/**
 * Archive / category fallback for posts.
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_archive_title();
$al_subtitle = get_the_archive_description();
$al_image    = AL_THEME_URI . '/assets/images/blog-1.jpeg';
include locate_template( 'template-parts/page-header.php' );

$paged = max( 1, get_query_var( 'paged' ) );
?>

<section class="al-section">
    <div class="al-container">
        <?php if ( have_posts() ) : ?>
            <div class="al-grid al-grid--3">
                <?php while ( have_posts() ) : the_post();
                    $img = get_the_post_thumbnail_url( null, 'al-blog' ) ?: AL_THEME_URI . '/assets/images/blog-1.jpeg';
                    $cats = get_the_category();
                    $cat  = $cats ? $cats[0]->name : __( 'Insight', 'allianzandco' );
                    ?>
                    <article class="al-post-card al-reveal">
                        <a class="al-post-card__media" href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                        <div class="al-post-card__body">
                            <div class="al-post-card__meta">
                                <span class="al-cat"><?php echo esc_html( $cat ); ?></span>
                                <span>·</span>
                                <time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                            </div>
                            <h3 class="al-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="al-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
                            <a class="al-link" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Read article', 'allianzandco' ); ?>
                                <span class="al-link__arrow"><?php echo al_icon( 'arrow', 16 ); ?></span>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="al-pagination">
                <?php echo paginate_links( array( 'prev_text' => '&larr;', 'next_text' => '&rarr;', 'type' => 'plain' ) ); ?>
            </div>
        <?php else : ?>
            <p class="al-text-center"><?php esc_html_e( 'No posts found.', 'allianzandco' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();
