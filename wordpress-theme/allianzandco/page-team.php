<?php
/**
 * Template Name: Our Team
 *
 * @package AllianzAndCo
 */
get_header();

$al_title    = get_the_title();
$al_subtitle = 'A continent-wide team of engineers, builders and operators who care deeply about the projects they deliver.';
$al_image    = get_the_post_thumbnail_url( null, 'full' ) ?: AL_THEME_URI . '/assets/images/about-2.jpg';
include locate_template( 'template-parts/page-header.php' );
?>

<section class="al-section">
    <div class="al-container">
        <?php
        $team_q = new WP_Query( array( 'post_type' => 'al_team', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
        if ( $team_q->have_posts() ) : ?>
            <div class="al-grid al-grid--4">
                <?php while ( $team_q->have_posts() ) : $team_q->the_post();
                    $img  = get_the_post_thumbnail_url( null, 'al-team' ) ?: AL_THEME_URI . '/assets/images/team-lead.jpg';
                    $role = get_post_meta( get_the_ID(), '_al_role', true );
                    $li   = get_post_meta( get_the_ID(), '_al_linkedin', true );
                    $tw   = get_post_meta( get_the_ID(), '_al_twitter', true );
                    ?>
                    <div class="al-reveal">
                        <a href="<?php the_permalink(); ?>" class="al-member">
                            <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <div class="al-member__overlay">
                                <h3 class="al-member__name"><?php the_title(); ?></h3>
                                <span class="al-member__role"><?php echo esc_html( $role ); ?></span>
                                <div class="al-member__social">
                                    <?php if ( $li ) : ?><a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><?php echo al_icon( 'user', 14 ); ?></a><?php endif; ?>
                                    <?php if ( $tw ) : ?><a href="<?php echo esc_url( $tw ); ?>" target="_blank" rel="noopener" aria-label="Twitter"><?php echo al_icon( 'mail', 14 ); ?></a><?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p class="al-text-center"><?php esc_html_e( 'No team members found.', 'allianzandco' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="al-cta">
    <div class="al-container al-cta__inner">
        <h2 class="al-cta__title"><?php esc_html_e( 'Join the team', 'allianzandco' ); ?></h2>
        <a class="al-btn al-btn--white al-btn--lg" href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">
            <?php esc_html_e( 'Get in touch', 'allianzandco' ); ?>
            <span class="al-btn__icon"><?php echo al_icon( 'arrow', 16 ); ?></span>
        </a>
    </div>
</section>

<?php get_footer();
