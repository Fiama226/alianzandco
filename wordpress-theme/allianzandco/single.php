<?php
/**
 * Single post (blog article) template.
 *
 * @package AllianzAndCo
 */
get_header();

while ( have_posts() ) : the_post();
    $img = get_the_post_thumbnail_url( null, 'al-project-lg' ) ?: AL_THEME_URI . '/assets/images/blog-1.jpeg';
    $al_title    = get_the_title();
    $al_subtitle = get_the_excerpt();
    $al_image    = $img;
    $al_breadcrumbs = true;
    include locate_template( 'template-parts/page-header.php' );
    ?>

    <section class="al-section">
        <div class="al-container">
            <div class="al-single-post al-reveal">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="al-single-post__hero">
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                <?php endif; ?>

                <div class="al-single-post__meta al-flex" style="gap: 1.5rem; color: var(--al-color-text-muted); font-size: .95rem; margin-bottom: 2rem;">
                    <span><?php echo get_the_date(); ?></span>
                    <span>·</span>
                    <span><?php printf( esc_html__( '%d min read', 'allianzandco' ), al_reading_time() ); ?></span>
                    <?php $cats = get_the_category(); if ( $cats ) : ?>
                        <span>·</span>
                        <span><?php echo esc_html( $cats[0]->name ); ?></span>
                    <?php endif; ?>
                </div>

                <div class="al-single-post__content">
                    <?php the_content(); ?>
                </div>

                <div class="al-flex al-flex--between al-flex--wrap" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--al-color-border);">
                    <?php $tags = get_the_tags(); if ( $tags ) : ?>
                        <div class="al-tags">
                            <?php foreach ( $tags as $t ) : ?>
                                <a class="al-tag" href="<?php echo esc_url( get_tag_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="al-author-box">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                    <div>
                        <h4><?php the_author(); ?></h4>
                        <p><?php echo esc_html( get_the_author_meta( 'description' ) ?: __( 'Contributor at Alliance & Co — sharing insights from the field.', 'allianzandco' ) ); ?></p>
                    </div>
                </div>

                <div class="al-single-post__nav">
                    <?php $prev = get_previous_post(); $next = get_next_post(); ?>
                    <?php if ( $prev ) : ?>
                        <a class="al-post-nav" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
                            <span>&larr; <?php esc_html_e( 'Previous', 'allianzandco' ); ?></span>
                            <strong><?php echo esc_html( $prev->post_title ); ?></strong>
                        </a>
                    <?php else : ?><div></div><?php endif; ?>
                    <?php if ( $next ) : ?>
                        <a class="al-post-nav" href="<?php echo esc_url( get_permalink( $next ) ); ?>" style="text-align: right;">
                            <span><?php esc_html_e( 'Next', 'allianzandco' ); ?> &rarr;</span>
                            <strong><?php echo esc_html( $next->post_title ); ?></strong>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
            </div>
        </div>
    </section>

<?php endwhile; get_footer();
