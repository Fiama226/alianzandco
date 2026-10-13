<?php
/**
 * Single Team Member template.
 *
 * @package AllianzAndCo
 */
get_header();

while ( have_posts() ) : the_post();
    $img  = get_the_post_thumbnail_url( null, 'al-team' ) ?: AL_THEME_URI . '/assets/images/team-lead.jpg';
    $role = get_post_meta( get_the_ID(), '_al_role', true );
    $li   = get_post_meta( get_the_ID(), '_al_linkedin', true );
    $tw   = get_post_meta( get_the_ID(), '_al_twitter', true );
    $em   = get_post_meta( get_the_ID(), '_al_email', true );
    $al_title = get_the_title();
    $al_image = $img;
    include locate_template( 'template-parts/page-header.php' );
    ?>

    <section class="al-section">
        <div class="al-container">
            <div class="al-feature-row">
                <div class="al-feature-row__media al-reveal">
                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                </div>
                <div class="al-reveal">
                    <?php if ( $role ) : ?>
                        <span class="al-eyebrow"><?php echo esc_html( $role ); ?></span>
                    <?php endif; ?>
                    <h1 style="font-size: clamp(2rem, 4vw, 3rem);"><?php the_title(); ?></h1>
                    <div class="al-single-post__content">
                        <?php the_content(); ?>
                    </div>
                    <ul class="al-contact-info" style="margin-top: 2rem;">
                        <?php if ( $em ) : ?>
                            <li class="al-contact-item">
                                <span class="al-contact-item__icon"><?php echo al_icon( 'mail', 20 ); ?></span>
                                <div>
                                    <h5><?php esc_html_e( 'Email', 'allianzandco' ); ?></h5>
                                    <p><a href="mailto:<?php echo esc_attr( $em ); ?>"><?php echo esc_html( $em ); ?></a></p>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ( $li ) : ?>
                            <li class="al-contact-item">
                                <span class="al-contact-item__icon"><?php echo al_icon( 'user', 20 ); ?></span>
                                <div>
                                    <h5><?php esc_html_e( 'LinkedIn', 'allianzandco' ); ?></h5>
                                    <p><a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener"><?php echo esc_html( preg_replace( '#^https?://#', '', $li ) ); ?></a></p>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ( $tw ) : ?>
                            <li class="al-contact-item">
                                <span class="al-contact-item__icon"><?php echo al_icon( 'user', 20 ); ?></span>
                                <div>
                                    <h5><?php esc_html_e( 'X / Twitter', 'allianzandco' ); ?></h5>
                                    <p><a href="<?php echo esc_url( $tw ); ?>" target="_blank" rel="noopener"><?php echo esc_html( preg_replace( '#^https?://#', '', $tw ) ); ?></a></p>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div style="margin-top: 4rem;">
                <a class="al-link" href="<?php echo esc_url( home_url( '/our-team' ) ); ?>">
                    <span class="al-link__arrow" style="transform: scaleX(-1);"><?php echo al_icon( 'arrow', 16 ); ?></span>
                    <?php esc_html_e( 'Back to the team', 'allianzandco' ); ?>
                </a>
            </div>
        </div>
    </section>

<?php endwhile; get_footer();
